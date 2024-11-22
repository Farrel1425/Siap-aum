apt-get install libreoffice --no-install-recommends
sudo apt-get install libreoffice-java-common default-jre
export HOME=/tmp
## Sebelum Sinkronisasi, Jalankan Query Berikut

```sql
DELETE
FROM
	kelengkapan_permohonan
WHERE
	kelengkapan_permohonan.id_permohonan IN (
	SELECT
		*
	FROM
		(
		SELECT DISTINCT
			( b.id_permohonan )
		FROM
			permohonan a
			RIGHT JOIN kelengkapan_permohonan b ON a.id = b.id_permohonan
		WHERE
			a.id IS NULL UNION
		SELECT DISTINCT
			( b.id_permohonan )
		FROM
			permohonan a
			RIGHT JOIN detail_permohonan b ON a.id = b.id_permohonan
		WHERE
			a.id IS NULL
		) AS c
	);
```

```sql
DELETE
FROM
	detail_permohonan
WHERE
	detail_permohonan.id_permohonan IN (
	SELECT
		*
	FROM
		(
		SELECT DISTINCT
			( b.id_permohonan )
		FROM
			permohonan a
			RIGHT JOIN kelengkapan_permohonan b ON a.id = b.id_permohonan
		WHERE
			a.id IS NULL UNION
		SELECT DISTINCT
			( b.id_permohonan )
		FROM
			permohonan a
			RIGHT JOIN detail_permohonan b ON a.id = b.id_permohonan
		WHERE
			a.id IS NULL
		) AS c
	);
```

```sql
DELETE
FROM
	alur_permohonan
WHERE
	id_user = 16
```

```sql
DELETE
FROM
	alur_permohonan
WHERE
	alur_permohonan.id_permohonan IN (
	SELECT
		*
	FROM
		(
		SELECT DISTINCT
			( b.id_permohonan )
		FROM
			permohonan a
			RIGHT JOIN alur_permohonan b ON a.id = b.id_permohonan
		WHERE
			a.id IS NULL
		) AS c
	);
```

```sql
DELETE
FROM
	kuisioner
WHERE
	kuisioner.id_permohonan IN (
	SELECT
		*
	FROM
		(
		SELECT DISTINCT
			( b.id_permohonan )
		FROM
			permohonan a
			RIGHT JOIN kuisioner b ON a.id = b.id_permohonan
		WHERE
			a.id IS NULL
		) AS c
	);
```

```sql

DELETE
FROM
	reklame_pembayaran
WHERE
	reklame_pembayaran.id_permohonan IN (
	SELECT
		*
	FROM
		(
		SELECT DISTINCT
			( b.id_permohonan )
		FROM
			permohonan a
			RIGHT JOIN reklame_pembayaran b ON a.id = b.id_permohonan
		WHERE
			a.id IS NULL
		) AS c
	);
```

```sql

UPDATE kuesioners
SET pendidikan = 'SMA/SMK'
WHERE
	pendidikan = 'SMA';
UPDATE kuesioners
SET pendidikan = 'DIPLOMA'
WHERE
	pendidikan = 'DIPL';
```

php artisan generate:ulid-jenis-izin

php artisan kuesioner:normalization
