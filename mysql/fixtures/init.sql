CREATE SCHEMA IF NOT EXISTS `nastydash` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `nastydash` ;

-- -----------------------------------------------------
-- Table `nastydash`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nastydash`.`customer` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `email_UNIQUE` ON `nastydash`.`customer` (`email` ASC) VISIBLE;

-- -----------------------------------------------------
-- Table `nastydash`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nastydash`.`order` (
  `purchase_date` DATETIME(1) NOT NULL,
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `country` VARCHAR(64) NOT NULL,
  `device` VARCHAR(45) NOT NULL,
  `customer_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `customer_id`),
  CONSTRAINT `fk_order_customer1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `nastydash`.`customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `nastydash`.`order` (`id` ASC) VISIBLE;
CREATE INDEX `fk_order_customer1_idx` ON `nastydash`.`order` (`customer_id` ASC) VISIBLE;

-- -----------------------------------------------------
-- Table `nastydash`.`item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nastydash`.`item` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ean` VARCHAR(45) NOT NULL,
  `quantity` INT UNSIGNED NOT NULL,
  `price` INT UNSIGNED NOT NULL,
  `order_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `order_id`),
  CONSTRAINT `fk_item_order`
    FOREIGN KEY (`order_id`)
    REFERENCES `nastydash`.`order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `nastydash`.`item` (`id` ASC) VISIBLE;
CREATE INDEX `fk_item_order_idx` ON `nastydash`.`item` (`order_id` ASC) VISIBLE;
