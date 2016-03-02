-- Table structure for table `order_address`
CREATE TABLE `order_address` (
  `address_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company` text,
  `street_address` text NOT NULL,
  `line2` text,
  `line3` text,
  `line4` text,
  `line5` text,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `pcl_response` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `order_line`
CREATE TABLE `order_line` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `parent_line_id` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `quantity_invoiced` int(11) DEFAULT NULL,
  `quantity_refunded` int(11) DEFAULT NULL,
  `quantity_shipped` int(11) DEFAULT NULL,
  `is_invoiceable` tinyint(4) DEFAULT NULL,
  `meta` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `order_order`
CREATE TABLE `order_order` (
  `id` int(11) NOT NULL,
  `ref_num` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `quote_id` int(11) DEFAULT NULL,
  `customer_id` varchar(13) DEFAULT NULL,
  `currency_code` varchar(20) DEFAULT NULL,
  `meta` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `order_order_address`
CREATE TABLE `order_order_address` (
  `order_id` int(11) NOT NULL DEFAULT '0',
  `address_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `order_order_tag`
CREATE TABLE `order_order_tag` (
  `order_id` int(11) NOT NULL DEFAULT '0',
  `tag_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `order_tag`
CREATE TABLE `order_tag` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Indexes for dumped tables
ALTER TABLE `order_address` ADD PRIMARY KEY (`address_id`);
ALTER TABLE `order_line` ADD PRIMARY KEY (`id`);
ALTER TABLE `order_order` ADD PRIMARY KEY (`id`);
ALTER TABLE `order_order_address` ADD PRIMARY KEY (`order_id`,`address_id`,`type`);
ALTER TABLE `order_order_tag` ADD PRIMARY KEY (`order_id`,`tag_id`);
ALTER TABLE `order_tag` ADD PRIMARY KEY (`id`);