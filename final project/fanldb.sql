-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- 主机: classroom.cs.unc.edu
-- 生成日期: 2013 年 12 月 10 日 21:34
-- 服务器版本: 5.1.71
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `fanldb`
--

-- --------------------------------------------------------

--
-- 表的结构 `ADMINISTRATOR`
--

CREATE TABLE IF NOT EXISTS `ADMINISTRATOR` (
  `a_id` int(11) NOT NULL,
  `username` char(30) NOT NULL,
  `password` char(30) NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `ADMINISTRATOR`
--

INSERT INTO `ADMINISTRATOR` (`a_id`, `username`, `password`) VALUES
(1, 'admin', 'comp426');

-- --------------------------------------------------------

--
-- 表的结构 `CUSTOMER`
--

CREATE TABLE IF NOT EXISTS `CUSTOMER` (
  `customer_id` int(11) NOT NULL,
  `username` char(20) NOT NULL,
  `password` char(20) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `CUSTOMER`
--

INSERT INTO `CUSTOMER` (`customer_id`, `username`, `password`) VALUES
(1, 'customer', 'comp426');

-- --------------------------------------------------------

--
-- 表的结构 `INVENTORY`
--

CREATE TABLE IF NOT EXISTS `INVENTORY` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` char(100) NOT NULL,
  `category` int(2) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `INVENTORY`
--

INSERT INTO `INVENTORY` (`item_id`, `item_name`, `category`, `price`, `stock`, `description`, `image`) VALUES
(4, 'BENEFIT COSMETICS Hello Flawler Powder', 5, '34.00', 7, 'A custom powder cover-up with a natural finish that builds from sheer to full coverage.', 'image/04.jpg'),
(5, 'SMASHBOX HALO Hydrating Perfect powder', 1, '59.00', 3, 'A face-perfecting antiaging powder and brush duo.', 'image/05.jpg'),
(6, 'URBAN DECAY De-Slick Mattifyin', 1, '32.00', 2, 'A transparent SPF 45 mineral powder in a convenient brush applicator.', 'image/06.jpg'),
(7, 'PETER THOMAS ROTH Instant Mine', 1, '33.00', 6, 'A transparent SPF 45 mineral powder in a convenient brush applicator.', 'image/07.jpg'),
(8, 'CLINIQUE Moisture Surge CC Cream', 1, '32.00', 3, 'An oil-free, color-correcting, perfecting formula to create a natural glow while hydrating and protecting the skin', 'image/08.jpg'),
(9, 'STILA Stay All Day 10-In-One', 1, '38.00', 5, 'An all-in-one, high-definition, age-defying beauty balm, enriched with broad-spectrum SPF 30', 'image/09.jpg'),
(10, 'TOO FACED Air Buffed BB Creme', 1, '37.00', 5, 'A five-in-one complete coverage beauty balm that perfects, mattifies, primes, and moisturizes.', 'image/10.jpg'),
(11, 'LANCOME LE STYLO WATERPROOF Eyeliner', 2, '24.00', 2, 'A long-lasting waterproof eyeliner.', 'image/11.jpg'),
(12, 'SHISEIDO The Makeup Accentuati Eyeliner', 2, '26.00', 7, 'Perfect pots of cream eyeliner.', 'image/12.jpg'),
(13, 'URBAN DECAY Naked2', 2, '52.00', 3, 'The most anticipated sequel of the decade, Naked2 features a dozen pigment-rich taupe and gray-beige neutrals, plus five exclusive, new shades.', 'image/13.jpg'),
(15, 'STILA In The Light Palette', 2, '39.00', 6, 'A beautiful palette consisting of 10 natural Eye Shadow shades (including the best-selling shade Kitten) and a limited-edition Smudge Stick Waterproof Eye Liner.', 'image/15.jpg'),
(16, 'MARC JACOBS BEAUTY Lovemarc Lip Gel Sets', 3, '350.00', 4, 'A limited-edition holiday set featuring 13 Lovemarc Lip Gels encased in a luxe lacquer box. ', 'image/16.jpg'),
(17, 'DOLCE & GABBANA Classic Cream', 3, '36.00', 3, 'A limited-edition holiday lip color inspired by the Autumn/Winter 2013/2014 runways. ', 'image/17.jpg'),
(18, 'DIOR Rouge Dior Couture Colour', 3, '21.00', 2, 'A luxurious, full-coverage lip color. ', 'image/18.jpg'),
(2, 'CLINIQUE Even Better Makeup SPF 15', 1, '31.00', 90, 'A dermatologist-developed liquid foundation that immediately brightens and evens out the skintone with naturally luminous minerals.', 'image/02.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `ORDER`
--

CREATE TABLE IF NOT EXISTS `ORDER` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_time` varchar(255) NOT NULL,
  `shipping_address` varchar(250) NOT NULL,
  `billing_address` varchar(250) NOT NULL,
  `email` char(30) NOT NULL,
  `zipcode` char(5) NOT NULL,
  `total_price` decimal(5,2) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- 转存表中的数据 `ORDER`
--

INSERT INTO `ORDER` (`order_id`, `customer_id`, `order_time`, `shipping_address`, `billing_address`, `email`, `zipcode`, `total_price`) VALUES
(73, 1, '12/09/2013 10:24:56 pm', '406 Hillsburgh St', '406 Hillsburgh St', 'duchenlin0709@gmail.com', '27516', '59.00'),
(72, 1, '12/09/2013 10:24:14 pm', '2804 Avent Ferry Rd', '100 Rock Haven Rd', 'gushumeng@hotmail.com', '27606', '179.00');

-- --------------------------------------------------------

--
-- 表的结构 `ORDER_ITEM`
--

CREATE TABLE IF NOT EXISTS `ORDER_ITEM` (
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `ORDER_ITEM`
--

INSERT INTO `ORDER_ITEM` (`order_id`, `item_id`, `quantity`) VALUES
(77, 5, 1),
(77, 11, 1),
(73, 5, 1),
(72, 15, 3),
(72, 2, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
