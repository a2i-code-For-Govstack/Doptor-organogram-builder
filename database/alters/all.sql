ALTER TABLE `employee_records`
    ADD `employee_grade` TINYINT(4) NULL AFTER `is_cadre`;

ALTER TABLE `user_login_history`
    CHANGE `mobile_number` `mobile_number` VARCHAR(13) NULL DEFAULT NULL;

# 20 June 2021 - System Registration
ALTER TABLE `api_clients`
    ADD `application_registration_id` INT(11) NOT NULL AFTER `name`;

ALTER TABLE `api_clients`
    ADD `modified` DATETIME NOT NULL AFTER `created`;

ALTER TABLE `api_clients`
    CHANGE `modified` `modified` DATETIME NOT NULL;

ALTER TABLE `api_clients`
    CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

ALTER TABLE `api_clients`
    ADD `status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `password`;


CREATE TABLE `application_registration`
(
    `id`                          INT(11)      NOT NULL AUTO_INCREMENT,
    `application_name_en`         VARCHAR(255) NOT NULL,
    `application_name_bn`         VARCHAR(255) NOT NULL,
    `url`                         VARCHAR(255) NOT NULL,
    `redirect_url`                VARCHAR(255) NULL,
    `default_page_url`            VARCHAR(255) NULL,
    `logout_url`                  VARCHAR(255) NULL,
    `logo_url`                    VARCHAR(255) NULL,
    `mobile_number`               VARCHAR(15)  NOT NULL,
    `email_address`               VARCHAR(64)  NOT NULL,
    `status`                      TINYINT(1)   NOT NULL DEFAULT '0',
    `is_rejected`                 TINYINT(1)   NOT NULL DEFAULT '0',
    `is_approved`                 TINYINT(1)   NOT NULL DEFAULT '0',
    `is_current`                  TINYINT(1)   NOT NULL DEFAULT '0',
    `is_published`                TINYINT(1)   NOT NULL DEFAULT '0',
    `helpdesk_phone`              VARCHAR(15)  NULL,
    `helpdesk_phone_alt`          VARCHAR(15)  NULL,
    `helpdesk_email`              VARCHAR(64)  NULL,
    `login_message`               VARCHAR(512) NULL     DEFAULT NULL,
    `is_framework`                TINYINT(1)   NOT NULL DEFAULT '0',
    `notification_medium`         TINYINT(2)   NOT NULL DEFAULT '0',
    `ip_address`                  VARCHAR(16)  NULL,
    `default_all_user_permission` TINYINT(1)   NOT NULL DEFAULT '0',
    `sso_type`                    TINYINT(1)   NOT NULL DEFAULT '0',
    `slo_url`                     VARCHAR(255) NULL,
    `created_by`                  INT(11)      NULL,
    `modified_by`                 INT(11)      NULL,
    `rejected_by`                 INT(11)      NULL,
    `is_deleted`                  TINYINT(1)   NOT NULL DEFAULT '0',
    `created`                     DATETIME     NOT NULL,
    `modified`                    DATETIME     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

UPDATE `menus`
SET `menu_link` = 'application_registration_approved',
    `menu_icon` = 'far fa-check-square'
WHERE `menus`.`id` = 71;

UPDATE `menus`
SET `menu_link` = 'application_registration_pending',
    `menu_icon` = 'far fa-list-alt'
WHERE `menus`.`id` = 73;

UPDATE `menus`
SET `menu_icon` = 'far fa-plus-square'
WHERE `menus`.`id` = 72;

INSERT INTO `menus` (`id`, `menu_name`, `menu_link`, `parent_menu_id`, `menu_icon`, `display_order`, `status`,
                     `created_at`, `updated_at`)
VALUES (NULL, 'স্থগিত অনুমোদিত এপ্লিকেশন', 'application_registration_suspended', '70', 'fas fa-times', '4', '1', NULL,
        NULL);

ALTER TABLE `office_unit_organograms`
    CHANGE `is_office_head` `is_office_head` TINYINT(1) NOT NULL DEFAULT '0',
    CHANGE `is_unit_admin` `is_unit_admin` TINYINT(1) NOT NULL DEFAULT '0',
    CHANGE `is_unit_head` `is_unit_head` TINYINT(1) NOT NULL DEFAULT '0';


-- SHOULD BE IMPLEMENTED
-- 2021-09-18
CREATE TABLE `password_histories`
(
    `id`                 INT UNSIGNED                          NOT NULL AUTO_INCREMENT,
    `user_id`            INT UNSIGNED                          NOT NULL,
    `employee_record_id` INT UNSIGNED                          NOT NULL,
    `password_hash`      VARCHAR(255)                          NOT NULL,
    `changed_date`       DATETIME                              NOT NULL,
    `created_at`         TIMESTAMP                             NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         TIMESTAMP on update CURRENT_TIMESTAMP NULL     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
-- 2022-04-26
ALTER TABLE `password_histories`
    CHANGE `user_id` `user_id` VARCHAR(255) NULL,
    CHANGE `employee_record_id` `employee_record_id` INT(11) UNSIGNED NULL;
CREATE TABLE `projapoti_db_test`.`password_histories`
(
    `id`                 INT UNSIGNED                          NOT NULL AUTO_INCREMENT,
    `user_id`            INT UNSIGNED                          NOT NULL,
    `employee_record_id` INT UNSIGNED                          NOT NULL,
    `password_hash`      VARCHAR(255)                          NOT NULL,
    `changed_date`       DATETIME                              NOT NULL,
    `created_at`         TIMESTAMP                             NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         TIMESTAMP on update CURRENT_TIMESTAMP NULL     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- 2022-05-14
CREATE TABLE `special_designations`
(
    `id`                        INT(11)   NOT NULL AUTO_INCREMENT,
    `office_id`                 INT       NOT NULL,
    `prime_minister`            INT       NULL,
    `minister`                  INT       NULL,
    `state_minister`            INT       NULL,
    `deputy_minister`           INT       NULL,
    `secretary`                 INT       NULL,
    `prime_minister_front_desk` INT       NULL,
    `added_by_record_id`        INT       NULL,
    `created_at`                TIMESTAMP NULL,
    `updated_at`                TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- 2022-06-20
ALTER TABLE `employee_offices`
    ADD `released_by` INT NULL AFTER `protikolpo_status`;

-- 2022-06-22
ALTER TABLE `office_origin_units`
    ADD `unit_sequence` INT NULL AFTER `unit_level`;

-- 2022-06-29
CREATE TABLE `admin_responsibility_logs`
(
    `id`                        int(11)      NOT NULL,
    `office_id`                 int(11)      NOT NULL,
    `office_unit_id`            int(11)      NOT NULL,
    `office_unit_organogram_id` int(11)      NOT NULL,
    `employee_id`               int(11)               DEFAULT NULL,
    `employee_name_en`          varchar(255)          DEFAULT NULL,
    `employee_name_bn`          varchar(255)          DEFAULT NULL,
    `assign_from`               date         NOT NULL,
    `assign_to`                 date                  DEFAULT NULL,
    `admin_type`                varchar(255) NOT NULL,
    `created_at`                datetime     NOT NULL,
    `updated_at`                timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
ALTER TABLE `admin_responsibility_logs`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `admin_responsibility_logs`
    CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
-- after this alter a new menu should be created link: office_admin_responsibility_log, name: অফিস অ্যাডমিন দায়িত্ব ইতিহাস, parent: office


-- 2022-09-25
ALTER TABLE `employee_records`
    ADD `surname_eng` VARCHAR(255) NOT NULL AFTER `name_eng`;
ALTER TABLE `employee_records`
    ADD `surname_bng` VARCHAR(255) NOT NULL AFTER `name_bng`;

ALTER TABLE `application_registration`
    ADD `custom_login_template` VARCHAR(255) NULL AFTER `logo_url`;
ALTER TABLE `application_registration`
    ADD `is_widget_show` TINYINT(1) NULL AFTER `is_published`;
ALTER TABLE `application_registration`
    ADD `sync_api_url` VARCHAR(255) NULL AFTER `slo_url`;
ALTER TABLE `application_registration`
    CHANGE `logo_url` `logo_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `application_registration`
    ADD `api_url` VARCHAR(255) NULL AFTER `sync_api_url`;
