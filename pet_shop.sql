SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+00:00';


-- Table structure for table `admins`

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table `admins`

INSERT INTO `admins` VALUES 
('1', 'admin', '$2y$10$whNeX/XMMWEhIHFB8cdD2.fOQTu/PhdLvdX2JYEsrcMJXs02uZXpW', 'Main Admin', 'admin', '2026-04-26 10:06:11');


-- Table structure for table `gallery`

DROP TABLE IF EXISTS `gallery`;
CREATE TABLE `gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_url` varchar(255) NOT NULL,
  `caption` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table `gallery`

INSERT INTO `gallery` VALUES 
('1', 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=600&q=80', 'Loyal Friend', 'Dogs'),
('2', 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80', 'Sleepy Kitty', 'Cats'),
('3', 'https://images.unsplash.com/photo-1452857297128-d9c29adba80b?auto=format&fit=crop&w=600&q=80', 'Colorful Parrot', 'Birds'),
('4', 'https://images.unsplash.com/photo-1520241669650-6d4b0797a2ca?auto=format&fit=crop&w=600&q=80', 'Goldfish Wonder', 'Fish'),
('5', 'https://images.unsplash.com/photo-1548191265-cc70d3d45ba1?auto=format&fit=crop&w=600&q=80', 'Puppy Love', 'Dogs'),
('6', 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?auto=format&fit=crop&w=600&q=80', 'Cool Cat', 'Cats'),
('7', 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=600&q=80', 'Loyal Dog', 'Dogs'),
('8', 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80', 'Sleepy Cat', 'Cats'),
('9', 'https://images.unsplash.com/photo-1452857297128-d9c29adba80b?auto=format&fit=crop&w=600&q=80', 'Beautiful Bird', 'Birds');


-- Table structure for table `order_items`

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `item_id` int NOT NULL,
  `item_type` varchar(20) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table `order_items`

INSERT INTO `order_items` VALUES 
('1', '1', '1', 'pet', 'Max', '500.00', '1'),
('2', '2', '2', 'pet', 'Luna', '450.00', '1'),
('3', '3', '1', 'product', 'Premium Dog Food (5kg)', '24.99', '2'),
('4', '4', '1', 'pet', 'Max', '5000.00', '1');


-- Table structure for table `orders`

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `shipping_address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table `orders`

INSERT INTO `orders` VALUES 
('1', '4', '500.00', 'pending', 'cod', '474,4th st, ganapathy mills colony, Sankar nagar., Tamil Nadu, India - 627357', '2026-04-28 10:58:59'),
('2', '4', '450.00', 'delivered', 'cod', '474,4th st, ganapathy mills colony, Sankar nagar., Tamil Nadu, India - 627357', '2026-04-28 10:59:25'),
('3', '4', '49.98', 'delivered', 'cod', '474,4th st, ganapathy mills colony, Sankar nagar., Tamil Nadu, India - 627357', '2026-04-28 11:03:00'),
('4', '4', '5000.00', 'pending', 'cod', 'dthgg, dgtg, India - 2356', '2026-04-30 11:23:32');


-- Table structure for table `pets`

DROP TABLE IF EXISTS `pets`;
CREATE TABLE `pets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `age` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'available',
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table `pets`

INSERT INTO `pets` VALUES 
('1', 'Max', 'Golden Retriever', '2 Years', 'Dog', '5000.00', 'sold', 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=600&q=80', 'A friendly and energetic retriever.', '2026-04-26 10:06:12'),
('2', 'Luna', 'Persian Cat', '3 Months', 'Cat', '450.00', 'sold', 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=600&q=80', 'A calm and beautiful kitten.', '2026-04-26 10:06:12'),
('3', 'Oliver', 'Beagle', '1 Year', 'Dog', '400.00', 'available', 'https://images.unsplash.com/photo-1537151608828-ea2b11777ee8?auto=format&fit=crop&w=600&q=80', 'Loves to play and sniff around.', '2026-04-26 10:06:12'),
('4', 'Buddy', 'Labrador Retriever', '3 Years', 'Dog', '600.00', 'available', 'https://images.unsplash.com/photo-1579213838826-b258679f1eb5?auto=format&fit=crop&w=600&q=80', 'A very friendly and active Labrador.', '2026-04-28 11:17:15'),
('5', 'Charlie', 'French Bulldog', '1 Year', 'Dog', '850.00', 'available', 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=600&q=80', 'Playful and affectionate.', '2026-04-28 11:17:15'),
('6', 'Bella', 'Poodle', '2 Years', 'Dog', '700.00', 'available', 'https://images.unsplash.com/photo-1596492784531-6e6eb5ea9993?auto=format&fit=crop&w=600&q=80', 'Smart and elegant Poodle.', '2026-04-28 11:17:15'),
('7', 'Rocky', 'German Shepherd', '6 Months', 'Dog', '0.00', 'available', 'https://images.unsplash.com/photo-1589965716319-4a041b58fa8a?auto=format&fit=crop&w=600&q=80', 'A rescue looking for a strong and loving family. (Adoption)', '2026-04-28 11:17:15'),
('8', 'Milo', 'British Shorthair', '2 Years', 'Cat', '550.00', 'available', 'https://images.unsplash.com/photo-1513360371669-4adf3dd7dff8?auto=format&fit=crop&w=600&q=80', 'Chubby and cuddly companion.', '2026-04-28 11:17:15'),
('9', 'Chloe', 'Siamese', '1 Year', 'Cat', '450.00', 'available', 'https://images.unsplash.com/photo-1513245543132-31f507417b26?auto=format&fit=crop&w=600&q=80', 'Vocal and very affectionate.', '2026-04-28 11:17:15'),
('10', 'Simba', 'Maine Coon', '4 Months', 'Cat', '900.00', 'available', 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?auto=format&fit=crop&w=600&q=80', 'Gentle giant kitten.', '2026-04-28 11:17:15'),
('11', 'Lily', 'Mixed Breed', '3 Years', 'Cat', '0.00', 'available', 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80', 'Sweet rescue cat waiting for adoption.', '2026-04-28 11:17:15'),
('12', 'Rio', 'Macaw', '5 Years', 'Bird', '1200.00', 'available', 'https://images.unsplash.com/photo-1552728089-571ebd6a45ad?auto=format&fit=crop&w=600&q=80', 'Colorful and highly intelligent.', '2026-04-28 11:17:15'),
('13', 'Tweety', 'Canary', '1 Year', 'Bird', '80.00', 'available', 'https://images.unsplash.com/photo-1522276498395-f4f68f7f8454?auto=format&fit=crop&w=600&q=80', 'Sings beautifully all day.', '2026-04-28 11:17:15'),
('14', 'Kiwi', 'Cockatiel', '8 Months', 'Bird', '150.00', 'available', 'https://images.unsplash.com/photo-1544421160-c3d3a042918d?auto=format&fit=crop&w=600&q=80', 'Friendly and easy to train.', '2026-04-28 11:17:15'),
('15', 'Sunny', 'Parakeet', '2 Years', 'Bird', '0.00', 'available', 'https://images.unsplash.com/photo-1601323315729-ab5cc054817d?auto=format&fit=crop&w=600&q=80', 'Looking for a new forever cage. (Adoption)', '2026-04-28 11:17:15');


-- Table structure for table `products`

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `rating` decimal(3,1) DEFAULT '0.0',
  `stock` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table `products`

INSERT INTO `products` VALUES 
('1', 'Premium Dog Food (5kg)', 'food', '24.99', '30.00', 'https://images.unsplash.com/photo-1589924691995-400dc9ce53ce?auto=format&fit=crop&w=300&q=80', 'Complete nutrition for active dogs.', '4.5', '98', '2026-04-26 11:14:36'),
('2', 'Cat Scratching Post', 'accessories', '18.50', NULL, 'https://images.unsplash.com/photo-1523626752472-b55a628f1acc?auto=format&fit=crop&w=300&q=80', 'Durable and fun scratching post.', '4.0', '50', '2026-04-26 11:14:36'),
('3', 'Organic Pet Shampoo', 'grooming', '12.99', NULL, 'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=300&q=80', 'Gentle shampoo for all pets.', '5.0', '75', '2026-04-26 11:14:36'),
('4', 'Flea & Tick Drops', 'medicine', '35.00', '45.00', 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=300&q=80', 'Effective protection for your pets.', '4.5', '30', '2026-04-26 11:14:36');


-- Table structure for table `users`

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table `users`

INSERT INTO `users` VALUES 
('1', 'Inba', 'Selvan', 'inba@gmail.com', '1234567890', '$2y$10$wheqKewNcrGYV/mxAhSdR.4.o548wM.Dl6YEYos8YYsRDZXgnWSpa', 'hufgyuhguikj', '2026-04-24 02:15:05'),
('2', 'kanaga', 'dharshni', 'saranya2005@gmail.com', '1234567890', '$2y$10$/7BCdJFdl2UP9LW86piEweGs7blqDKfRlllaRje4Zabtnm3uyf5OC', NULL, '2026-04-24 11:16:00'),
('3', 'Nivetha', 'p', 'nivethaparamasivan@gmail.com', '2134567890', '$2y$10$V6OyzbdsmyYXID9eeHUP4eP720lrJhW2wIvGRv4DgT9KYaGaA9966', NULL, '2026-04-26 11:32:56'),
('4', 'Saranya', 'N', 'saran28@gmail.com', '2134567890', '$2y$10$js0/IMZ0qnzLpfF2CTKcF.iD/1AwsSNshhy780wpuAk2y3CrKO4nO', NULL, '2026-04-28 10:45:32');


-- Table structure for table `wishlist`

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `item_id` int NOT NULL,
  `item_type` varchar(20) DEFAULT 'product',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_fav` (`user_id`,`item_id`,`item_type`),
  CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table `wishlist`

INSERT INTO `wishlist` VALUES 
('1', '4', '9', 'pet', '2026-04-30 11:23:49');

