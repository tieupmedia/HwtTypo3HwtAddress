#
# Table structure for table 'tx_hwtaddress_domain_model_address'
#
CREATE TABLE tx_hwtaddress_domain_model_address (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,

    sorting int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    starttime int(11) DEFAULT '0' NOT NULL,
    endtime int(11) DEFAULT '0' NOT NULL,

    academic varchar(20) DEFAULT '' NOT NULL,
    firstname tinytext NOT NULL,
    lastname tinytext NOT NULL,
    gender int(1) DEFAULT '0' NOT NULL,

    images int(11) unsigned DEFAULT '0',
    birthday int(11) DEFAULT '0' NOT NULL,
    info text,

    department tinytext,
    position tinytext,

    company_title tinytext,
    company_subtitle tinytext,
    company_short text,
    company_bodytext mediumtext,
    company_images int(11) unsigned DEFAULT '0',

    phone varchar(30) DEFAULT '' NOT NULL,
    mobile varchar(30) DEFAULT '' NOT NULL,
    fax varchar(30) DEFAULT '' NOT NULL,
    email varchar(80) DEFAULT '' NOT NULL,
    www varchar(80) DEFAULT '' NOT NULL,
    links int(11) unsigned DEFAULT '0' NOT NULL,
    building varchar(20) DEFAULT '' NOT NULL,
    street tinytext,
    zip varchar(20) DEFAULT '' NOT NULL,
    city varchar(80) DEFAULT '' NOT NULL,

    region varchar(100) DEFAULT '' NOT NULL,
    country varchar(100) DEFAULT '' NOT NULL,

    longitude tinytext NOT NULL,
    latitude tinytext NOT NULL,

    related_address int(11) DEFAULT '0' NOT NULL,
    related_address_from int(11) DEFAULT '0' NOT NULL,

    related_pages int(11) DEFAULT '0' NOT NULL,
    related_pages_from int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

#
# Table structure for table 'tx_hwtaddress_domain_model_address_related_mm'
#
CREATE TABLE tx_hwtaddress_domain_model_address_related_mm (
    uid_local int(11) DEFAULT '0' NOT NULL,
    uid_foreign int(11) DEFAULT '0' NOT NULL,
    tablenames varchar(30) DEFAULT '' NOT NULL,
    sorting int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) DEFAULT '0' NOT NULL,
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign),
);

#
# Table structure for table 'tx_hwtaddress_domain_model_link'
#
CREATE TABLE tx_hwtaddress_domain_model_link (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,

    sorting int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    starttime int(11) DEFAULT '0' NOT NULL,
    endtime int(11) DEFAULT '0' NOT NULL,

    header tinytext NOT NULL,
    type tinytext NOT NULL,
    parameter varchar(1024) DEFAULT '' NOT NULL,
    linktext tinytext NOT NULL,

    address int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

#
# Table structure for table 'pages'
#
CREATE TABLE pages (
    tx_hwtaddress_related_address int(11) DEFAULT '0' NOT NULL,
    tx_hwtaddress_related_address_from int(11) DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_hwtaddress_domain_model_pages_address_mm'
#
CREATE TABLE tx_hwtaddress_domain_model_pages_address_mm (
    uid_local int(11) DEFAULT '0' NOT NULL,
    uid_foreign int(11) DEFAULT '0' NOT NULL,
    tablenames varchar(30) DEFAULT '' NOT NULL,
    sorting int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) DEFAULT '0' NOT NULL,
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'fe_users'
#
#CREATE TABLE fe_users (
#	tx_hwtaddress_addressmounts varchar(255) DEFAULT '' NOT NULL,
#);

#
# Table structure for table 'tx_hwtaddress_domain_model_feuser_address_mm'
#
#CREATE TABLE tx_hwtaddress_domain_model_feuser_address_mm (
#	uid_local int(11) DEFAULT '0' NOT NULL,
#	uid_foreign int(11) DEFAULT '0' NOT NULL,
#	sorting int(11) DEFAULT '0' NOT NULL,
#	KEY uid_local (uid_local),
#	KEY uid_foreign (uid_foreign),
#);