-- Vereinsnr hinzufuegen
-- hinweis: id ist schon auto_increment
ALTER TABLE `tas_vereine` ADD `vereinsnr` VARCHAR( 10 ) NOT NULL ;
UPDATE `tas_vereine` SET `vereinsnr` = `id` ;
ALTER TABLE `tas_vereine` MODIFY `vereinsnr` UNIQUE ;
update `tas_vereine` set `vereinsnr` = concat('05-', lpad(`vereinsnr`,5,0))

