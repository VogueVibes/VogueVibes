SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `semesterproject`
--

-- --------------------------------------------------------

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `anrede` varchar(10) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `status` varchar(200) NOT NULL DEFAULT 'Active',
  `profile_image` varchar(255) DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `email`, `anrede`, `password`, `role`, `status`, `profile_image`) VALUES
(1, 'Admin', 'User', 'admin', 'admin@gmail.com', 'Mr', 'admin12345', 1, 'Active', 'admin.png'); 

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --------------------------------------------------------

-- Create the basket table
CREATE TABLE `basket` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `name` varchar(255) DEFAULT NULL,
    `price` float DEFAULT NULL,
    `image` varchar(255) DEFAULT NULL,
    `quantity` int(11) DEFAULT NULL,
    `size` ENUM('S', 'M', 'L', 'XL') NOT NULL,
    `category` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Create the produkte table
CREATE TABLE `produkte` (
  `itemId` INT(10) NOT NULL AUTO_INCREMENT,
  `itemName` VARCHAR(50) NOT NULL,
  `itemPrice` FLOAT NOT NULL,
  `itemImage` VARCHAR(100) NOT NULL,
  `itemDescription` TEXT NOT NULL,
  `typeName` VARCHAR(50) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Regular items
INSERT INTO produkte (itemId, itemName, itemPrice, itemImage, itemDescription, typeName, category) VALUES
(1, 'Skull Pendant Necklace', 10.0, 'accessory1.png', 'This stylish skull pendant necklace adds a bold statement to any outfit. Perfect for those who love edgy accessories.', 'accessory', 'regular'),
(2, 'Yellow Wristband', 15.0, 'accessory2.png', 'A vibrant yellow wristband that is perfect for sports or casual wear. Comfortable and durable for everyday use.', 'accessory', 'regular'),
(3, 'Black Wristband', 12.0, 'accessory3.png', 'Sleek and minimalistic black wristband suitable for any occasion. Made with high-quality materials for long-lasting wear.', 'accessory', 'regular'),
(4, 'Cartoon Patch', 18.0, 'accessory4.png', 'Fun and quirky cartoon patch to customize your bags, jackets, or jeans. Easy to apply and adds a unique touch.', 'accessory', 'regular'),
(5, 'Black Balaclava', 20.0, 'accessory5.png', 'Warm and practical black balaclava, perfect for winter sports and cold weather.', 'accessory', 'regular'),
(6, 'Red Eyes Mask', 15.0, 'accessory6.png', 'Mysterious and stylish mask with red eye design. Ideal for costume parties and events.', 'accessory', 'regular'),
(7, 'Plaid Crossbody Bag', 40.0, 'bag2.png', 'Stylish plaid crossbody bag with ample storage space. Perfect for casual outings and daily use.', 'bag', 'regular'),
(8, 'Eco Tote Bag', 30.0, 'bag3.png', 'Eco-friendly tote bag ideal for shopping or everyday use. Made from sustainable materials and stylish design.', 'bag', 'regular'),
(9, 'Nike Gym Bag', 35.0, 'bag22.png', 'A versatile Nike gym bag that is spacious and durable. Perfect for carrying your workout essentials.', 'bag', 'regular'),
(10, 'Minimalist Waist Bag', 32.0, 'bags.png', 'Convenient and sleek waist bag to keep your essentials close. Perfect for travel and outdoor activities.', 'bag', 'regular'),
(11, 'I Hate Mondays Hoodie', 25.0, 'hoodie4.png', 'Cozy up in our "I Hate Mondays" hoodie. Ideal for lazy days and casual outings, featuring a relaxed fit and soft fabric.', 'hoodie', 'regular'),
(12, 'Scream Face Hoodie', 25.0, 'hoodie5.png', 'Express your inner rebel with the "Scream Face" hoodie. Perfect for those who love bold and unique fashion statements.', 'hoodie', 'regular'),
(13, 'Retro Graphic Hoodie', 30.0, 'hoodie7.png', 'Retro graphic hoodie with a stylish design. Comfortable and perfect for casual wear.', 'hoodie', 'regular'),
(14, 'Simple Black Hoodie', 50.0, 'hoodie.png', 'Stay warm and stylish with this classic black hoodie. A wardrobe essential for any casual outfit.', 'hoodie', 'regular'),
(15, 'Smiley Face Hoodie', 55.0, 'hoodie1.png', 'Brighten your day with the smiley face hoodie. Comfortable and cheerful, perfect for any casual occasion.', 'hoodie', 'regular'),
(16, 'Cool Graphic Hoodie', 45.0, 'hoodie8.png', 'Cool graphic hoodie that pairs well with any outfit. Soft and comfortable for everyday wear.', 'hoodie', 'regular'),
(17, 'Sporty Hoodie', 35.0, 'hoodie9.png', 'Sporty hoodie designed for active lifestyles. Comfortable and stylish.', 'hoodie', 'regular'),
(18, 'Graphic Zipper Hoodie', 60.0, 'hoodiezip2.png', 'Comfortable zipper hoodie with a unique graphic design. Perfect for layering.', 'hoodie', 'regular'),
(19, 'High-Top Sneakers', 80.0, 'image57.png', 'Trendy high-top sneakers that combine style and comfort. Ideal for casual wear and street style.', 'sneakers', 'regular'),
(20, 'Tan Sneakers', 85.0, 'sneaker2.png', 'Versatile tan sneakers suitable for various outfits. Comfortable and stylish for everyday wear.', 'sneakers', 'regular'),
(21, 'Black Casual Sneakers', 100.0, 'sneaker3.png', 'Casual black sneakers that provide comfort and durability. Ideal for daily use.', 'sneakers', 'regular'),
(22, 'Sporty Sneakers', 95.0, 'sneaker4.png', 'Sporty sneakers designed for active lifestyles. Lightweight and comfortable.', 'sneakers', 'regular'),
(23, 'Blue Trim Sneakers', 105.0, 'sneaker5.png', 'Stylish sneakers with a blue trim. Perfect for adding a pop of color to your look.', 'sneakers', 'regular'),
(24, 'White and Black Sneakers', 110.0, 'sneaker6.png', 'Classic white and black sneakers that are both stylish and versatile.', 'sneakers', 'regular'),
(25, 'Black and White High-Tops', 115.0, 'sneaker7.png', 'High-top sneakers with a black and white design. Comfortable and fashionable.', 'sneakers', 'regular'),
(26, 'High-Top Fashion Sneakers', 120.0, 'sneaker8.png', 'Fashion-forward high-top sneakers that make a statement. Ideal for trendy outfits.', 'sneakers', 'regular'),
(27, 'White Sneakers', 90.0, 'sneaker32.png', 'Classic white sneakers that offer both style and comfort. Perfect for any casual outfit.', 'sneakers', 'regular'),
(28, 'White Crew Socks', 12.0, 'socks1.png', 'Comfortable white crew socks. Perfect for daily wear and sports activities.', 'accessory', 'regular'),
(29, 'Pastel Pink Socks', 10.0, 'socks52.png', 'Cute and comfy pastel pink socks. Perfect for adding a touch of color to your outfit.', 'accessory', 'regular'),
(30, 'Retro Graphic T-Shirt', 20.0, 't-shirt.png', 'Vintage-inspired graphic t-shirt with a retro design. Soft and breathable fabric for everyday wear.', 'tshirts', 'regular'),
(31, 'Cool Graphic T-Shirt', 22.0, 'tshirt3.png', 'Cool graphic t-shirt perfect for casual outings. Breathable fabric for comfort.', 'tshirts', 'regular'),
(32, 'I Hate Antihype T-Shirt', 25.0, 'tshirt1.png', 'Express your unique style with the "I Hate Antihype" t-shirt. Comfortable and trendy.', 'tshirts', 'regular'),
(33, 'Artistic Graphic T-Shirt', 30.0, 'tshirt2.png', 'Artistic graphic t-shirt that showcases your unique style. Soft and breathable.', 'tshirts', 'regular'),
(34, 'Cartoon Graphic Tee', 18.0, 'tshirt.png', 'Fun and colorful cartoon graphic tee. Perfect for casual wear.', 'tshirts', 'regular'),
(35, 'Retro Car T-Shirt', 25.0, 'tshirt11.png', 'Cool retro car t-shirt with a unique graphic design. Perfect for car lovers and casual wear.', 'tshirts', 'regular');

-- Exclusive items
INSERT INTO produkte (itemId, itemName, itemPrice, itemImage, itemDescription, typeName, category) VALUES
(36, 'Black Adidas Sneakers', 120.0, 'black.png', 'Sleek black Adidas sneakers that offer style and comfort. Perfect for everyday wear.', 'sneakers', 'brand'),
(37, 'Purple and Beige Jacket', 200.0, 'TNF.png', 'Stylish purple and beige jacket that provides warmth and comfort. Ideal for cold weather.', 'accessory', 'brand'),
(38, 'Supreme x THF Jacket', 250.0, 'supremexthf.png', 'Exclusive Supreme x THF jacket with unique design. A must-have for fashion enthusiasts.', 'accessory', 'brand'),
(39, 'Black Bucket Hat', 30.0, 'cap.png', 'Stylish black bucket hat that adds a trendy touch to any outfit. Perfect for sunny days.', 'accessory', 'brand'),
(40, 'Brand Hoodie', 75.0, 'hoodieBrand.png', 'High-quality hoodie with brand logo. Comfortable and stylish for everyday wear.', 'hoodie', 'brand'),
(41, 'Exclusive Mask', 20.0, 'mask.png', 'Unique mask with exclusive design. Perfect for making a bold statement.', 'accessory', 'brand'),
(42, 'Exclusive T-Shirt', 35.0, 't-shirtE.png', 'Exclusive t-shirt with a limited edition design. Soft and comfortable for everyday wear.', 'tshirts', 'brand'),
(43, 'Exclusive Graphic Hoodie', 60.0, 'hoodieE.png', 'High-quality graphic hoodie with unique design. Stylish and comfortable for everyday wear.', 'hoodie', 'brand');

-- --------------------------------------------------------

-- Create the purchased table
CREATE TABLE purchased (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) DEFAULT NULL,
    price FLOAT DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    size VARCHAR(10) DEFAULT NULL,
    category VARCHAR(50) DEFAULT NULL,
    purchase_date DATETIME DEFAULT NULL,
    tracking_code VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
