<?php

namespace App\Models;

use App\Enums\HeroBannerMediaType;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    protected static function booted(): void
    {
        static::saving(function (HeroBanner $banner): void {
            $banner->normalizeUploadedPathAttributes();
            $banner->purgeFieldsNotUsedByType();
        });
    }

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'media_type',
        'image_url',
        'image_disk_path',
        'video_url',
        'video_disk_path',
        'youtube_video_id',
        'video_poster_url',
        'video_poster_disk_path',
        'is_active',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'media_type' => HeroBannerMediaType::class,
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Đường dẫn web cho file trên disk public: /storage/...
     * Dùng đường gốc theo domain hiện tại (ngrok, production) thay vì URL tuyệt đối từ APP_URL
     * (tránh trỏ localhost khi xem bằng tunnel trên điện thoại).
     */
    public static function publicStorageWebPath(?string $diskRelativePath): ?string
    {
        if ($diskRelativePath === null || $diskRelativePath === '') {
            return null;
        }

        return '/storage/'.ltrim($diskRelativePath, '/');
    }

    public function resolvedPosterUrl(): ?string
    {
        if ($this->video_poster_url) {
            return $this->video_poster_url;
        }
        if ($this->video_poster_disk_path) {
            return self::publicStorageWebPath($this->video_poster_disk_path);
        }

        return null;
    }

    /**
     * URL ảnh nền (ảnh tĩnh hoặc poster).
     */
    public function resolvedBackgroundImageUrl(): ?string
    {
        $type = $this->media_type;

        if ($type === HeroBannerMediaType::ImageUrl && $this->image_url) {
            return $this->image_url;
        }
        if ($type === HeroBannerMediaType::ImageUpload && $this->image_disk_path) {
            return self::publicStorageWebPath($this->image_disk_path);
        }

        return $this->resolvedPosterUrl();
    }

    public function resolvedVideoSrc(): ?string
    {
        $type = $this->media_type;

        if ($type === HeroBannerMediaType::VideoUrl && $this->video_url) {
            return $this->video_url;
        }
        if ($type === HeroBannerMediaType::VideoUpload && $this->video_disk_path) {
            return self::publicStorageWebPath($this->video_disk_path);
        }

        return null;
    }

    public function youtubeEmbedSrc(): ?string
    {
        if ($this->media_type !== HeroBannerMediaType::Youtube || ! $this->youtube_video_id) {
            return null;
        }

        $id = $this->youtube_video_id;

        return 'https://www.youtube-nocookie.com/embed/'.$id
            .'?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1&controls=0'
            .'&loop=1&playlist='.rawurlencode($id);
    }

    /**
     * Filament đôi khi dehydrate FileUpload thành mảng một phần tử — chuẩn hoá về string cho cột DB.
     */
    public function normalizeUploadedPathAttributes(): void
    {
        foreach (['image_disk_path', 'video_disk_path', 'video_poster_disk_path'] as $attr) {
            $v = $this->{$attr};
            if (is_array($v)) {
                $first = reset($v);
                $this->{$attr} = is_string($first) && $first !== '' ? $first : null;
            }
        }
    }

    /**
     * Xoá dữ liệu không thuộc loại media đang chọn để tránh nhầm khi đổi loại trong admin.
     */
    public function purgeFieldsNotUsedByType(): void
    {
        $t = $this->media_type;
        if ($t === null) {
            return;
        }

        if ($t !== HeroBannerMediaType::ImageUrl) {
            $this->image_url = null;
        }
        if ($t !== HeroBannerMediaType::ImageUpload) {
            $this->image_disk_path = null;
        }
        if ($t !== HeroBannerMediaType::VideoUrl) {
            $this->video_url = null;
        }
        if ($t !== HeroBannerMediaType::VideoUpload) {
            $this->video_disk_path = null;
        }
        if ($t !== HeroBannerMediaType::Youtube) {
            $this->youtube_video_id = null;
        }
        if (! $t->isVideo()) {
            $this->video_poster_url = null;
            $this->video_poster_disk_path = null;
        }
    }

    /**
     * Đủ dữ liệu để hiển thị theo loại media đã chọn.
     */
    public function isRenderable(): bool
    {
        $t = $this->media_type;
        if ($t === null) {
            return false;
        }

        return match ($t) {
            HeroBannerMediaType::ImageUrl => filled($this->image_url),
            HeroBannerMediaType::ImageUpload => filled($this->image_disk_path),
            HeroBannerMediaType::VideoUrl => filled($this->video_url),
            HeroBannerMediaType::VideoUpload => filled($this->video_disk_path),
            HeroBannerMediaType::Youtube => filled($this->youtube_video_id),
        };
    }

    /**
     * Có ít nhất một lớp media (ảnh / video / YouTube).
     */
    public function slideHasRenderableMedia(): bool
    {
        $t = $this->media_type;
        if ($t === HeroBannerMediaType::ImageUrl || $t === HeroBannerMediaType::ImageUpload) {
            return (bool) $this->resolvedBackgroundImageUrl();
        }
        if ($t === HeroBannerMediaType::VideoUrl || $t === HeroBannerMediaType::VideoUpload) {
            return (bool) $this->resolvedVideoSrc();
        }
        if ($t === HeroBannerMediaType::Youtube) {
            return (bool) $this->youtubeEmbedSrc();
        }

        return false;
    }

    public static function normalizeYoutubeInput(?string $input): ?string
    {
        if ($input === null || trim($input) === '') {
            return null;
        }
        $input = trim($input);
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $input)) {
            return $input;
        }
        $patterns = [
            '#(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([a-zA-Z0-9_-]{11})#',
            '#youtube\.com/shorts/([a-zA-Z0-9_-]{11})#',
        ];
        foreach ($patterns as $p) {
            if (preg_match($p, $input, $m)) {
                return $m[1];
            }
        }

        return null;
    }
}
