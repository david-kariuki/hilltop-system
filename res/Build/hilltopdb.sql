-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema hilltop
-- -----------------------------------------------------
-- Hill Top database

-- -----------------------------------------------------
-- Schema hilltop
--
-- Hill Top database
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `hilltop` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `hilltop` ;

-- -----------------------------------------------------
-- Table `hilltop`.`tbl_Users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_Users` (
  `UUID` INT NOT NULL,
  `firstName` VARCHAR(100) NULL,
  `lastName` VARCHAR(100) NULL,
  `otherName` VARCHAR(100) NULL,
  `gender` VARCHAR(20) NULL,
  `nationalId` VARCHAR(10) NULL,
  `Email` VARCHAR(100) NOT NULL,
  `userName` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NULL,
  `Address` VARCHAR(255) NULL,
  `city` VARCHAR(100) NULL,
  `role` VARCHAR(25) NOT NULL,
  `status` VARCHAR(30) NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `lastModified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `logID` VARCHAR(255) NULL,
  PRIMARY KEY (`UUID`),
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC),
  UNIQUE INDEX `userName_UNIQUE` (`userName` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_vendors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_vendors` (
  `UUID` INT NOT NULL,
  `vendorName` VARCHAR(150) NULL,
  `Address1` VARCHAR(120) NULL,
  `city` VARCHAR(100) NULL,
  `Address2` VARCHAR(120) NULL,
  `Tel` VARCHAR(20) NULL,
  `postalCode` VARCHAR(100) NULL,
  `Email` VARCHAR(70) NULL,
  `Notes` MEDIUMTEXT NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_createdBy` INT NULL,
  `dateModified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_modifiedBy` INT NULL,
  PRIMARY KEY (`UUID`),
  INDEX `vendorCreatedBy_idx` (`fk_createdBy` ASC),
  INDEX `vendorUpdatedBy_idx` (`fk_modifiedBy` ASC),
  CONSTRAINT `vendorCreatedBy`
    FOREIGN KEY (`fk_createdBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `vendorUpdatedBy`
    FOREIGN KEY (`fk_modifiedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '	';


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_products` (
  `UUID` INT NOT NULL,
  `productName` VARCHAR(100) NULL,
  `productType` VARCHAR(50) NULL,
  `fk_addedBy` INT NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_modifiedBy` INT NULL,
  `dateModified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibility` TINYINT(2) NULL DEFAULT 1,
  `enableEdit` TINYINT(2) NULL DEFAULT 1,
  `Notes` TINYINT(2) NULL DEFAULT 1,
  PRIMARY KEY (`UUID`),
  INDEX `productCreation_idx` (`fk_addedBy` ASC),
  INDEX `updatedBy_idx` (`fk_modifiedBy` ASC),
  CONSTRAINT `productCreation`
    FOREIGN KEY (`fk_addedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `updatedBy`
    FOREIGN KEY (`fk_modifiedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_storage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_storage` (
  `UUID` INT NOT NULL,
  `storage_name` VARCHAR(45) NULL,
  `description` MEDIUMTEXT NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_createdBy` INT NULL,
  `dateModified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_modifiedBy` INT NULL,
  PRIMARY KEY (`UUID`),
  UNIQUE INDEX `storage_name_UNIQUE` (`storage_name` ASC),
  INDEX `storageCreatedBy_idx` (`fk_createdBy` ASC),
  INDEX `storageUpdatedBy_idx` (`fk_modifiedBy` ASC),
  CONSTRAINT `storageCreatedBy`
    FOREIGN KEY (`fk_createdBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `storageUpdatedBy`
    FOREIGN KEY (`fk_modifiedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_inventory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_inventory` (
  `UUID` INT NOT NULL,
  `fk_productID` INT NULL,
  `fk_storageID` INT NULL,
  `currentStock` DECIMAL(15) NULL,
  `lowStockThreashold` DECIMAL(15) NULL,
  `regularPrice` DECIMAL(15,2) NULL,
  `salePrice` DECIMAL(15,2) NULL,
  `includedTaxPercent` DECIMAL(4,2) NULL,
  `fk_createdBy` INT NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_modifiedBy` INT NULL,
  `dateModified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UUID`),
  INDEX `product_bing_idx` (`fk_productID` ASC),
  INDEX `storage_bind_idx` (`fk_storageID` ASC),
  INDEX `inventoryCreatedBy_idx` (`fk_createdBy` ASC),
  INDEX `inventoryModifiedBy_idx` (`fk_modifiedBy` ASC),
  CONSTRAINT `product_bing`
    FOREIGN KEY (`fk_productID`)
    REFERENCES `hilltop`.`tbl_products` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `storage_bind`
    FOREIGN KEY (`fk_storageID`)
    REFERENCES `hilltop`.`tbl_storage` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `inventoryCreatedBy`
    FOREIGN KEY (`fk_createdBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `inventoryModifiedBy`
    FOREIGN KEY (`fk_modifiedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_category` (
  `UUID` INT NOT NULL,
  `categoryName` VARCHAR(100) NULL,
  `category_description` MEDIUMTEXT NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_createdBy` INT NULL,
  `dateModified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modifiedBy` INT NULL,
  PRIMARY KEY (`UUID`),
  INDEX `categoryAddedBy_idx` (`fk_createdBy` ASC),
  INDEX `categoryUpdatedBy_idx` (`modifiedBy` ASC),
  CONSTRAINT `categoryAddedBy`
    FOREIGN KEY (`fk_createdBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `categoryUpdatedBy`
    FOREIGN KEY (`modifiedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_categoryValues`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_categoryValues` (
  `UUID` INT NOT NULL,
  `categoryID` INT NULL,
  `categoryValue` VARCHAR(100) NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_createdBy` INT NULL,
  `dateModified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_modifiedBy` INT NULL,
  PRIMARY KEY (`UUID`),
  INDEX `category_bind_idx` (`categoryID` ASC),
  INDEX `categoryValues_idx` (`fk_createdBy` ASC),
  INDEX `categoryUpdatedBy_idx` (`fk_modifiedBy` ASC),
  CONSTRAINT `fk_category`
    FOREIGN KEY (`categoryID`)
    REFERENCES `hilltop`.`tbl_category` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_creation`
    FOREIGN KEY (`fk_createdBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modification`
    FOREIGN KEY (`fk_modifiedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_tags` (
  `UUID` INT NOT NULL,
  `tagName` VARCHAR(100) NULL,
  `tagDescription` MEDIUMTEXT NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_createdBy` INT NULL,
  `dateModified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_modifiedBy` INT NULL,
  PRIMARY KEY (`UUID`),
  INDEX `tagsAddedBy_idx` (`fk_createdBy` ASC),
  INDEX `tagsUpdatedBy_idx` (`fk_modifiedBy` ASC),
  CONSTRAINT `tagsAddedBy`
    FOREIGN KEY (`fk_createdBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `tagsUpdatedBy`
    FOREIGN KEY (`fk_modifiedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_tagEntry`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_tagEntry` (
  `fk_tagID` INT NULL,
  `fk_productID` INT NULL,
  INDEX `tags_tag_listing_idx` (`fk_tagID` ASC),
  INDEX `product_inventory_listing_idx` (`fk_productID` ASC),
  CONSTRAINT `tags_tag_listing`
    FOREIGN KEY (`fk_tagID`)
    REFERENCES `hilltop`.`tbl_tags` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `product_inventory_listing`
    FOREIGN KEY (`fk_productID`)
    REFERENCES `hilltop`.`tbl_inventory` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_categoryEntry`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_categoryEntry` (
  `fk_categoryValueID` INT NULL,
  `fk_productID` INT NULL,
  INDEX `category_listing_idx` (`fk_categoryValueID` ASC),
  INDEX `sub_product_listing_idx` (`fk_productID` ASC),
  CONSTRAINT `category_listing`
    FOREIGN KEY (`fk_categoryValueID`)
    REFERENCES `hilltop`.`tbl_categoryValues` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `sub_product_listing`
    FOREIGN KEY (`fk_productID`)
    REFERENCES `hilltop`.`tbl_inventory` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_customer` (
  `UUID` INT NOT NULL,
  `socialTitle` VARCHAR(45) NULL,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `otherName` VARCHAR(45) NULL,
  `Email` VARCHAR(45) NULL,
  `phoneNumber1` VARCHAR(45) NULL,
  `phoneNumber2` VARCHAR(45) NULL,
  `Address` VARCHAR(45) NULL,
  `City` VARCHAR(45) NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_createdBy` INT NULL,
  `dateModified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_modifiedBy` INT NULL,
  PRIMARY KEY (`UUID`),
  INDEX `customerCreatedBy_idx` (`fk_createdBy` ASC),
  INDEX `UpdatedBy_idx` (`fk_modifiedBy` ASC),
  CONSTRAINT `fk_customer_creation`
    FOREIGN KEY (`fk_createdBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customer_modification`
    FOREIGN KEY (`fk_modifiedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_notifications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_notifications` (
  `NotificationID` INT NOT NULL,
  `fk_From` INT NULL,
  `subject` VARCHAR(100) NULL,
  `message` LONGTEXT NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`NotificationID`),
  INDEX `createdBy_idx` (`fk_From` ASC),
  CONSTRAINT `createdBy`
    FOREIGN KEY (`fk_From`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_recepients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_recepients` (
  `UUID` INT NOT NULL,
  `fk_messagerID` INT NULL,
  `fk_recipient` INT NULL,
  PRIMARY KEY (`UUID`),
  INDEX `notificationref_idx` (`fk_messagerID` ASC),
  INDEX `recepient_idx` (`fk_recipient` ASC),
  CONSTRAINT `notificationref`
    FOREIGN KEY (`fk_messagerID`)
    REFERENCES `hilltop`.`tbl_notifications` (`NotificationID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `recepient`
    FOREIGN KEY (`fk_recipient`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_sale`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_sale` (
  `sale_ID` INT NOT NULL,
  `fk_saleRep` INT NULL,
  `saleType` VARCHAR(45) NULL,
  `fk_customer` INT NULL,
  `customerTel` VARCHAR(20) NULL,
  `deliverAddress` VARCHAR(150) NULL,
  `saleQuantity` INT NULL,
  `amount` DECIMAL(15,2) NULL,
  `saleNote` MEDIUMTEXT NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sale_ID`),
  INDEX `customerLink_idx` (`fk_customer` ASC),
  INDEX `saleCreatedBy_idx` (`fk_saleRep` ASC),
  CONSTRAINT `customerLink`
    FOREIGN KEY (`fk_customer`)
    REFERENCES `hilltop`.`tbl_customer` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `saleCreatedBy`
    FOREIGN KEY (`fk_saleRep`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_subSale`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_subSale` (
  `UUID` INT NOT NULL,
  `fk_SaleID` INT NULL,
  `fk_productID` INT NULL,
  `quantity` INT NULL,
  `Price` DECIMAL(15,2) NULL,
  `subTotal` DECIMAL(15,2) NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_createdBy` INT NULL,
  PRIMARY KEY (`UUID`),
  INDEX `sale_reference_idx` (`fk_SaleID` ASC),
  INDEX `product_ref_idx` (`fk_productID` ASC),
  INDEX `subsaleCreatedBy_idx` (`fk_createdBy` ASC),
  CONSTRAINT `sale_reference`
    FOREIGN KEY (`fk_SaleID`)
    REFERENCES `hilltop`.`tbl_sale` (`sale_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `product_ref`
    FOREIGN KEY (`fk_productID`)
    REFERENCES `hilltop`.`tbl_inventory` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `subsaleCreatedBy`
    FOREIGN KEY (`fk_createdBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_transaction` (
  `UUID` INT NOT NULL,
  `fk_saleReference` INT NULL,
  `fk_customerReference` INT NULL,
  `transactionType` VARCHAR(45) NULL,
  `transactionValue` DECIMAL(15,2) NULL,
  `category` VARCHAR(45) NULL,
  `transactionMethode` VARCHAR(45) NULL,
  `dateCreated` DATETIME NULL,
  `fk_createdBy` INT NULL,
  `dateModified` DATETIME NULL,
  `fk_modifiedBy` INT NULL,
  PRIMARY KEY (`UUID`),
  INDEX `sales_reference_idx` (`fk_saleReference` ASC),
  INDEX `customer_ref_idx` (`fk_customerReference` ASC),
  INDEX `createdBytransaction_idx` (`fk_createdBy` ASC),
  INDEX `transactionModifiedBy_idx` (`fk_modifiedBy` ASC),
  CONSTRAINT `sales_reference`
    FOREIGN KEY (`fk_saleReference`)
    REFERENCES `hilltop`.`tbl_sale` (`sale_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `customer_ref`
    FOREIGN KEY (`fk_customerReference`)
    REFERENCES `hilltop`.`tbl_customer` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `createdBytransaction`
    FOREIGN KEY (`fk_createdBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `transactionModifiedBy`
    FOREIGN KEY (`fk_modifiedBy`)
    REFERENCES `hilltop`.`tbl_Users` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hilltop`.`tbl_vendorListing`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hilltop`.`tbl_vendorListing` (
  `fk_subProductID` INT NULL,
  `vendorID` INT NULL,
  INDEX `productListing_idx` (`fk_subProductID` ASC),
  INDEX `vendorlisting_idx` (`vendorID` ASC),
  CONSTRAINT `productListing`
    FOREIGN KEY (`fk_subProductID`)
    REFERENCES `hilltop`.`tbl_products` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `vendorlisting`
    FOREIGN KEY (`vendorID`)
    REFERENCES `hilltop`.`tbl_vendors` (`UUID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
