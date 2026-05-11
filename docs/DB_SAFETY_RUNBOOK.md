# Database Safety Runbook

Muc tieu: tranh mat du lieu do thao tac nham khi lam viec local/Docker.

## 1) Nguyen tac bat buoc

- Khong chay lenh pha huy du lieu neu chua co xac nhan ro rang.
- Uu tien lenh an toan:
  - Duoc phep: `php artisan migrate`, `php artisan db:seed`, `php artisan migrate:status`
  - Cam mac dinh: `php artisan migrate:fresh`, `php artisan db:wipe`, `docker compose down -v`
- Truoc moi thao tac DB co ghi, luon:
  1. Xac nhan database dang target (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`)
  2. Tao backup nhanh
  3. Moi chay migrate/seed

## 2) Quy trinh thao tac chuan (SOP)

1. Kiem tra stack:
   - `docker compose ps`
2. Kiem tra migration:
   - `docker compose exec -w /var/www/html app php artisan migrate:status`
3. Tao backup:
   - `./scripts/db-backup.sh`
4. Chay migrate an toan:
   - `./scripts/db-safe-migrate.sh`
5. (Neu can) seed bo sung:
   - `docker compose exec -w /var/www/html app php artisan db:seed --force`
6. Verify sau cung:
   - Dem so dong cac bang chinh bang tinker hoac dashboard admin

## 3) Quy tac xac nhan khi can reset

Chi duoc reset khi:
- Co yeu cau truc tiep tu owner
- Da backup thanh cong
- Da ghi ro ly do trong ghi chu cong viec

Lenh pha huy du lieu chi duoc phep neu truyen bien moi truong:

`ALLOW_DB_DESTRUCTIVE=1`

## 4) Backup va restore nhanh

- Backup tao file SQL timestamp:
  - `./scripts/db-backup.sh`
- File backup mac dinh:
  - `storage/backups/db_YYYYmmdd_HHMMSS.sql`
- Restore thu cong:
  - `docker compose exec -T mariadb sh -lc 'mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"' < storage/backups/<file>.sql`

## 5) Dau hieu canh bao thuong gap

- Site trong khi migration status van "Ran":
  - Kha nang dang tro nham DB/volume moi
- Bang `users` = 0:
  - Da reset volume hoac wipe DB
- Sau khi `docker compose down -v`:
  - Du lieu MariaDB local bi xoa theo volume

## 6) Checklist truoc khi merge

- [ ] Da backup truoc thao tac DB
- [ ] Khong su dung lenh destructive neu khong duoc phep
- [ ] Migration tang tien, khong sua migration da deploy
- [ ] Da verify du lieu van ton tai sau khi thao tac
