-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 12:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `veggiedelights`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(1, 'italian', 'https://img.freepik.com/free-photo/top-view-table-full-delicious-food-assortment_23-2149141339.jpg'),
(2, 'North Indian', 'https://hometriangle.com/blogs/content/images/2024/03/Catering-Ideas-Food-Suggestions-For-North-Indian-Weddings.jpg'),
(3, 'South Indian', 'https://assets.vogue.com/photos/63d169f727f1d528635b4287/3:2/w_3630,h_2420,c_limit/GettyImages-1292563627.jpg'),
(4, 'Chinese', 'https://img.freepik.com/premium-photo/set-assorted-chinese-food-table-with-female-hand-holding-chopsticks-from-full-festive-table-with-all-traditional-chinese-dishes-asian-style-dinner-buffet-top-view_92134-561.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `status`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(2, 0, 'Vinay', 'vinay@yahoo.com', 'regarding the notification section', 'i am not able to get the notification', '2025-11-11 16:56:30'),
(3, 0, 'Shyam', 'shyam@gmail.com', 'regarding uploading a recipe', 'i am not able to upload the recipe', '2025-11-11 17:00:11'),
(4, 0, 'Rekha Purohit', 'rekha@gmail.com', 'regarding add recipe in my recipes', 'i want details to how to add recipe to my recipes', '2025-11-25 20:53:48'),
(5, 0, 'Rajesh nayak', 'rajesh@yahoo.com', 'regarding new category details', 'i want information about new category', '2025-11-26 18:38:19'),
(6, 0, 'Nikitha Jain', 'nikitha@gmail.com', 'regarding add recipes', 'Iwant to know how to add recipes', '2025-11-26 20:16:53'),
(7, 0, 'Mahendra Sharma', 'mahendra@yahoo.com', 'regarding add recipes', 'I want details about add recipes', '2025-11-26 20:23:00'),
(8, 0, 'Naresh Gupta', 'naresh@gmail.com', 'regarding new updates', 'I want to have information about updates', '2025-11-29 11:01:12'),
(10, 0, 'kavyashree d.m mohan', 'kavyashreedm@gmail.com', 'regarding updates', 'i am not getting notifications', '2025-12-16 16:31:46');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `email`, `recipe_id`) VALUES
(27, 'kavyashreedm@gmail.com', 34),
(12, 'mahendra@yahoo.com', 3),
(10, 'mahendra@yahoo.com', 9),
(11, 'mahendra@yahoo.com', 14),
(9, 'mahendra@yahoo.com', 22),
(19, 'naresh@gmail.com', 6),
(20, 'naresh@gmail.com', 8),
(24, 'naresh@gmail.com', 15),
(23, 'naresh@gmail.com', 18),
(26, 'naresh@gmail.com', 20),
(25, 'naresh@gmail.com', 24),
(21, 'naresh@gmail.com', 25),
(22, 'naresh@gmail.com', 26),
(6, 'nikitha@gmail.com', 6),
(7, 'nikitha@gmail.com', 13),
(8, 'nikitha@gmail.com', 16),
(5, 'nikitha@gmail.com', 22),
(4, 'Rajesh@yahoo.com', 4),
(2, 'Rajesh@yahoo.com', 11),
(3, 'Rajesh@yahoo.com', 16),
(1, 'Rajesh@yahoo.com', 23),
(14, 'rekha@gmail.com', 8),
(13, 'rekha@gmail.com', 10),
(16, 'rekha@gmail.com', 13),
(17, 'rekha@gmail.com', 17),
(15, 'rekha@gmail.com', 25),
(18, 'rekha@gmail.com', 31);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(2000) NOT NULL,
  `email` varchar(2000) NOT NULL,
  `rating` varchar(2000) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `rating`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'raju', 'raju@gmail.com', '5', 'There are plenty of useful recipes i happy to use this application', 0, '2025-10-29 13:17:42', '2025-10-29 13:17:42'),
(2, 'Rekha Purohit', 'rekha@gmail.com', '5', 'perfect!!', 0, '2025-11-25 15:24:20', '2025-11-25 15:24:20'),
(3, 'Rajesh nayak', 'rajesh@yahoo.com', '4', 'The recipe book is easy to use. :)', 0, '2025-11-26 13:09:21', '2025-11-26 13:09:21'),
(4, 'Mahendra Sharma', 'mahendra@yahoo.com', '5', 'The veggiedelights recipe book is very user friendly.', 0, '2025-11-26 14:59:21', '2025-11-26 14:59:21'),
(5, 'Naresh Gupta', 'naresh@gmail.com', '5', 'the recipe book is easy to access!!:)', 0, '2025-11-29 05:40:40', '2025-11-29 05:40:40'),
(6, 'kavyashree d.m mohan', 'kavyashreedm@gmail.com', '4', 'good website!!', 0, '2025-12-16 05:09:22', '2025-12-16 05:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text NOT NULL,
  `steps` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `page_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `email`, `name`, `description`, `ingredients`, `steps`, `image`, `created_at`, `page_name`, `category`) VALUES
(1, 'rekha@gmail.com', 'Butter Naan', 'a soft, fluffy, leavened Indian flatbread that is brushed generously with melted butter or ghee after cooking', 'All-purpose flour, yogurt, milk, sugar, salt, baking powder, baking soda, ghee or butter, warm water', '1.Mix all dry ingredients (flour, sugar, salt, baking powder, baking soda) in a bowl.\r\n\r\n2.Add yogurt and milk, then knead into a soft dough.\r\n\r\n3.Cover the dough and let it rest for 1-2 hours.\r\n\r\n4.Divide the dough into small balls.\r\n\r\n5.Roll each ball into an oval shape.\r\n\r\n6.Heat a skillet or tawa, cook the naan until bubbles appear and the bottom is golden brown.\r\n\r\n7.Flip and cook the other side until golden.\r\n\r\n8.Brush generously with melted butter.\r\n\r\n9.Serve hot', 'https://fullofplants.com/wp-content/uploads/2023/05/Homemade-Naan-Bread-Restaurant-Style-Vegan-thumb-1.jpg', '2025-11-25 16:48:36', NULL, 'North Indian'),
(3, 'rekha@gmail.com', 'Veg Manchow Soup', 'a spicy, dark brown broth made with vegetables or chicken, thickened with cornstarch, and flavored with soy sauce, garlic, ginger, and chili peppers', 'Carrot, cabbage, capsicum, beans, spring onion, garlic, ginger, green chili, soy sauce, vinegar, cornflour, vegetable stock, salt, pepper, oil, spring onion greens', '1.Finely chop all vegetables: carrot, cabbage, capsicum, beans, and spring onion.\r\n\r\n2.Heat oil in a pan, add garlic, ginger, and green chili, sauté for 30 seconds.\r\n\r\n3.Add chopped vegetables and stir-fry for 2-3 minutes.\r\n\r\n4.Add soy sauce, vinegar, salt, and pepper. Mix well.\r\n\r\n5.Pour in vegetable stock and bring it to a boil.\r\n\r\n6.Mix cornflour with water to make a slurry. Slowly add it to the boiling soup while stirring.\r\n\r\n7.Simmer for 2-3 minutes until soup thickens.\r\n\r\n8.Garnish with chopped spring onion greens and serve hot.', 'https://easyindiancookbook.com/wp-content/uploads/2023/07/manchow-soup-veg-6.jpg', '2025-11-25 17:00:50', NULL, 'chinese'),
(4, 'rekha@gmail.com', 'Panna Cotta', 'Panna cotta is a smooth, creamy Italian dessert made by gently setting sweetened cream with gelatin, resulting in a silky, delicate texture often served with fruit or caramel sauce.', 'Heavy cream 2 cups, Granulated sugar 1/2 cup, Vanilla extract 1 tsp, Gelatin powder 2 1/2 tsp, Cold water 3 tbsp, Fresh berries or fruit coulis for topping', '1.Sprinkle gelatin over cold water in a small bowl and let it sit for 5–10 minutes to bloom.\r\n\r\n2.In a saucepan, combine heavy cream, sugar, and vanilla. Heat gently over medium heat until sugar dissolves (do not boil).\r\n\r\n3.Remove from heat and stir in the bloomed gelatin until fully dissolved.\r\n\r\n4.Pour the mixture into serving glasses or molds. Let it cool to room temperature.\r\n\r\n5.Refrigerate for at least 4 hours until set.\r\n\r\n6.Serve chilled, topped with fresh berries, fruit coulis, or a drizzle of chocolate or caramel sauce.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/80/Panna_Cotta_with_cream_and_garnish.jpg/1200px-Panna_Cotta_with_cream_and_garnish.jpg', '2025-11-25 17:30:12', NULL, 'Italian'),
(6, 'rekha@gmail.com', 'Gulab Jamun', 'Gulab Jamun is a soft fried milk-based sweet soaked in fragrant sugar syrup flavored with cardamom and saffron. It’s melt-in-the-mouth, juicy, and served warm as a classic North Indian dessert.', 'For Jamuns:\r\nKhoya/Mawa, Maida, Baking soda, Milk, Ghee/Oil\r\n\r\nFor Sugar Syrup:\r\nSugar, Water, Cardamom pods, Saffron strands, Rose water', '1.Make syrup – Boil sugar and water, add cardamom and saffron, simmer 8–10 mins until slightly sticky.\r\n\r\n2.Finish syrup – Add rose water, turn off heat, keep warm.\r\n\r\n3.Mix dough – Combine khoya, maida, baking soda gently.\r\n\r\n4.Add milk – Pour little milk to form a soft smooth dough, rest 10 mins.\r\n\r\n5.Shape balls – Make small crack-free balls.\r\n\r\n6.Heat ghee – Fry on low-medium heat, rolling continuously.\r\n\r\n7.Fry till golden – Remove when evenly brown.\r\n\r\n8.Soak – Rest 2 mins, then add to warm syrup.\r\n\r\n9.Absorb – Let soak at least 2 hours for softness.', 'https://www.cookwithnabeela.com/wp-content/uploads/2024/02/GulabJamun2-.webp', '2025-11-26 06:22:51', 'gulab_jamun.php', 'North Indian'),
(7, 'admin@veggiedelights.com', 'Paneer Butter Masala', 'A rich and creamy curry made with paneer cubes simmered in a buttery tomato gravy, flavored with spices and a hint of cream.', 'Paneer cubes, Butter, Cream, Tomato puree, Cashew paste, Ginger, Garlic, Spices (Garam masala, Red chili, Turmeric, Salt)', '1. Heat butter and sauté ginger & garlic. \r\n2. Add tomato puree and spices, cook for 5-7 min. \r\n3. Add cashew paste and cream. \r\n4. Add paneer cubes, simmer 5 min. \r\n5. Garnish with cream and serve.', 'https://sandhyahariharan.co.uk/wp-content/uploads/2022/07/paneer-butter-masala-2.jpg', '2025-11-26 07:33:22', 'paneerbuttermasala.php', 'North Indian'),
(8, 'admin@veggiedelights.com', 'Paneer Tikka', 'Chunks of marinated paneer grilled with vegetables, smoky and flavorful — a perfect North Indian starter.', 'Paneer cubes, Yogurt, Lemon juice, Red chili powder, Garam masala, Turmeric, Ginger-garlic paste, Salt, Oil', '1. Mix yogurt with spices and marinate paneer cubes for 2-3 hours. \r\n2. Skewer the cubes and grill or bake for 10-15 min. \r\n3. Serve hot with chutney.', 'https://spicecravings.com/wp-content/uploads/2020/10/Paneer-Tikka-Featured-1.jpg', '2025-11-26 07:33:22', 'paneertikka.php', 'North Indian'),
(9, 'admin@veggiedelights.com', 'Rajma Chawal', 'Comforting North Indian dish of red kidney beans cooked in spicy tomato gravy, served with steamed rice.', 'Kidney beans, Rice, Onion, Tomato, Ginger, Garlic, Spices (Cumin, Coriander, Red chili, Garam masala, Salt), Oil', '1. Soak kidney beans overnight and boil until soft. \r\n2. Sauté onions, ginger, garlic, tomatoes with spices. \r\n3. Add boiled beans, cook 10 min. \r\n4. Serve with steamed rice.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrY-YDbNH_JLFnMOh26A1l7WKFgORHz6C3uQ&s', '2025-11-26 07:33:22', 'rajmachawal.php', 'North Indian'),
(10, 'admin@veggiedelights.com', 'Dal Makhani', 'Slow-cooked whole black lentils and kidney beans in a creamy, buttery sauce for a luxurious North Indian delicacy.', 'Urad dal (black lentils), Rajma (kidney beans), Butter, Cream, Tomato puree, Ginger, Garlic, Spices (Garam masala, Red chili, Turmeric, Salt)', '1. Soak lentils and rajma overnight, boil until soft. \r\n2. Heat butter, sauté ginger & garlic. \r\n3. Add tomato puree and spices, simmer 10 min. \r\n4. Add lentils & rajma, cook on low heat 20-25 min. \r\n5. Add cream, simmer 5 min. Serve hot.', 'https://www.sharmispassions.com/wp-content/uploads/2012/05/dal-makhani7-500x500.jpg', '2025-11-26 07:33:22', 'dalmakhani.php', 'North Indian'),
(11, 'admin@veggiedelights.com', 'Idli', 'Soft, fluffy steamed rice cakes perfect for breakfast.', 'Rice, Urad dal, Water, Salt', '1. Soak rice and urad dal separately for 4-6 hours. \r\n2. Grind to smooth batter and mix. \r\n3. Ferment overnight. \r\n4. Pour batter into idli molds and steam for 10-12 min. \r\n5. Serve hot with chutney.', 'https://static.toiimg.com/thumb/msid-113810989,width-1280,height-720,resizemode-4/113810989.jpg', '2025-11-26 07:39:39', 'idli.php', 'South Indian'),
(12, 'admin@veggiedelights.com', 'Dosa', 'Crispy rice and lentil crepes served with sambar and chutney.', 'Rice, Urad dal, Fenugreek seeds, Water, Salt, Oil', '1. Soak rice and dal with fenugreek seeds for 4-6 hours. \r\n2. Grind to a smooth batter. \r\n3. Ferment overnight. \r\n4. Spread batter thinly on a hot griddle and cook until crispy. \r\n5. Serve with sambar and chutney.', 'https://vismaifood.com/storage/app/uploads/public/8b4/19e/427/thumb__1200_0_0_0_auto.jpg', '2025-11-26 07:39:39', 'dosa.php', 'South Indian'),
(13, 'admin@veggiedelights.com', 'Bisibelebath', 'Aromatic, tangy spiced rice and lentil porridge.', 'Rice, Toor dal, Tamarind paste, Sambar powder, Curry leaves, Mustard seeds, Spices, Salt, Oil', '1. Cook rice and dal until soft. \r\n2. Prepare tamarind water and mix with cooked dal and sambar powder. \r\n3. Cook rice with dal mixture, add spices and curry leaves. \r\n4. Simmer until thick. Serve hot.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4yNAg8mINQeky1Wln4RUS2XAeIJtf1TaKMw&s', '2025-11-26 07:39:39', 'bisibelebath.php', 'South Indian'),
(14, 'admin@veggiedelights.com', 'Onion Pakoda', 'Crispy golden fried onion fritters, perfect as a snack.', 'Onions, Gram flour, Rice flour, Green chilies, Curry leaves, Spices (Red chili, Turmeric, Salt), Oil', '1. Slice onions and mix with gram flour, rice flour, chopped chilies, curry leaves, and spices. \r\n2. Heat oil in a pan. \r\n3. Drop small portions of mixture into hot oil and fry until golden. \r\n4. Drain on paper towels and serve hot with chutney.', 'https://www.mygingergarlickitchen.com/wp-content/rich-markup-images/16x9/16x9-pyaaz-pakoda-onion-fritters.jpg', '2025-11-26 07:39:39', 'onionpakoda.php', 'South Indian'),
(15, 'admin@veggiedelights.com', 'Mapo Tofu', 'A classic Sichuan dish featuring soft tofu in a spicy, flavorful sauce made with fermented bean paste and chili, perfect with steamed rice.', 'Soft tofu, minced garlic, ginger, green onions, fermented bean paste, chili paste, soy sauce, vegetable oil, cornstarch, water', '1. Heat oil in a pan.\r\n2. Add garlic, ginger, and green onions, stir-fry.\r\n3. Add fermented bean paste and chili paste, cook 2 mins.\r\n4. Add tofu and soy sauce.\r\n5. Mix cornstarch with water, pour in, simmer until sauce thickens.\r\n6. Serve hot with steamed rice.', 'https://cdn.apartmenttherapy.info/image/upload/f_jpg,q_auto:eco,c_fill,g_auto,w_1500,ar_1:1/k%2F2023-05-mapo-tofu%2Fmapo-tofu-017', '2025-11-26 07:48:24', 'mapotofu.php', 'Chinese'),
(16, 'admin@veggiedelights.com', 'Vegetable Noodles', 'Stir-fried noodles tossed with a colorful mix of fresh vegetables, flavored with soy sauce and garlic for a quick and tasty meal.', 'Noodles, bell peppers, carrots, cabbage, garlic, soy sauce, sesame oil, green onions', '1. Cook noodles and set aside.\r\n2. Heat oil in a wok, sauté garlic.\r\n3. Add vegetables and stir-fry until tender.\r\n4. Add noodles and soy sauce.\r\n5. Toss everything well and cook 2-3 mins.\r\n6. Serve hot.', 'https://www.kannammacooks.com/wp-content/uploads/Vegetable-Hakka-Noodles-Recipe-1-3.jpg', '2025-11-26 07:48:24', 'vegetablenoodles.php', 'Chinese'),
(17, 'admin@veggiedelights.com', 'Vegetable Fried Rice', 'A simple yet flavorful dish made with stir-fried rice, mixed vegetables, and soy sauce, perfect as a main or side dish.', 'Cooked rice, mixed vegetables, garlic, soy sauce, sesame oil, salt, pepper', '1. Heat oil in a pan, sauté garlic.\n2. Add mixed vegetables and cook 2-3 mins.\n3. Add cooked rice and soy sauce.\n4. Stir-fry until evenly mixed.\n5. Season with salt and pepper.\n6. Serve warm.', 'https://www.sharmispassions.com/wp-content/uploads/2011/01/VegFriedRice2.jpg', '2025-11-26 07:48:24', 'friedrice.php', 'Chinese'),
(18, 'admin@veggiedelights.com', 'Vegetable Spring Rolls', 'Crispy rolls filled with fresh vegetables and lightly seasoned, perfect as a snack or appetizer with dipping sauce.', 'Spring roll wrappers, cabbage, carrots, bell peppers, soy sauce, garlic, oil', '1. Prepare filling by stir-frying vegetables with garlic and soy sauce.\n2. Place filling on spring roll wrapper and roll tightly.\n3. Deep fry until golden and crisp.\n4. Drain excess oil on paper towel.\n5. Serve hot with dipping sauce.', 'https://media.istockphoto.com/id/486940812/photo/baked-spring-rolls-with-deep-vegetables-and-rice.jpg?s=612x612&w=0&k=20&c=rQ5NCxvLHt8zhO3oXFCU8QCfoVG_94jKTMWjti05Bso=', '2025-11-26 07:48:24', 'springroll.php', 'Chinese'),
(19, 'admin@veggiedelights.com', 'Vegetable Lasagna', 'Layers of pasta, veggies, and rich tomato sauce topped with melted cheese. Pure comfort food!', 'Lasagna pasta sheets, tomato sauce, bell peppers, zucchini, spinach, mozzarella cheese, ricotta cheese, olive oil, garlic, Italian herbs', '1. Preheat oven to 375°F (190°C).\n2. Sauté vegetables with garlic and olive oil.\n3. Spread tomato sauce on baking dish.\n4. Layer pasta sheets, vegetables, ricotta, and mozzarella.\n5. Repeat layers and top with cheese.\n6. Bake 35-40 mins until golden.\n7. Let it cool slightly, then serve.', 'https://www.inspiredtaste.net/wp-content/uploads/2016/10/Easy-Vegetable-Lasagna-Recipe-1200.jpg', '2025-11-26 07:51:00', 'Lasagna.php', 'Italian'),
(20, 'admin@veggiedelights.com', 'Margherita Pizza', 'A classic thin-crust pizza topped with tangy tomato sauce, mozzarella, and fresh basil leaves.', 'Pizza dough, tomato sauce, mozzarella cheese, fresh basil leaves, olive oil, salt', '1. In a bowl mix 2 cups flour, 1 tsp yeast, 1 tsp sugar, 1 tsp salt, and 1 tbsp olive oil, then add warm water gradually and knead into a soft dough.\r\n2. Cover the dough and let it rest in a warm place for 1–1.5 hours until doubled in size.\r\n3. Preheat the oven to 230°C (450°F) and place a pizza stone or baking tray inside to heat.\r\n4. Punch down the risen dough and divide it into one or two balls depending on desired pizza size.\r\n5. Dust the surface with flour and gently stretch or roll the dough into a thin round base with a slightly raised edge.\r\n6. Spread a thin layer of pizza sauce evenly over the base, leaving a small border around the edges.\r\n7. Arrange fresh mozzarella slices evenly on top without overcrowding the surface.\r\n8. Drizzle a little olive oil over the cheese and lightly season with salt and black pepper.\r\n9. Transfer the pizza onto the preheated tray or stone and bake for 10–12 minutes until the crust is golden and cheese is melted and bubbly.\r\n10. Remove from the oven, top with fresh basil leaves, rest for 2 minutes, slice, and serve hot.\r\n\r\n\r\n', 'https://media.istockphoto.com/id/1393150881/photo/italian-pizza-margherita-with-cheese-and-tomato-sauce-on-the-board-on-grey-table-macro-close.jpg?s=612x612&w=0&k=20&c=kL0Vhg2XKBjEl__iG8sFv31WTiahdpLc3rTDtNZuD2g=', '2025-11-26 07:51:00', 'pizza.php', 'Italian'),
(21, 'admin@veggiedelights.com', 'Pasta Primavera', 'Fresh seasonal vegetables tossed with creamy white sauce and Italian herbs. Light and delicious!', 'Pasta (penne or spaghetti), bell peppers, zucchini, carrots, broccoli, garlic, olive oil, cream, parmesan cheese, Italian herbs, salt, pepper', '\r\n1. Bring a large pot of salted water to a boil and cook 300g pasta until al dente, then drain and reserve ½ cup pasta water.\r\n2. Heat 2 tbsp olive oil in a pan and sauté sliced carrots for 2 minutes until slightly softened.\r\n3. Add broccoli florets and cook for another 2 minutes while stirring.\r\n4. Add sliced bell peppers and zucchini and continue cooking for 3–4 minutes until the vegetables are tender-crisp.\r\n5. Stir in minced garlic and cherry tomatoes and cook for 1 minute until fragrant and tomatoes begin to soften.\r\n6. Season the vegetables with salt, black pepper, and Italian herbs while keeping the heat on medium.\r\n7. Add the cooked pasta into the pan and toss with the vegetables until combined.\r\n8. Pour in ¼ cup reserved pasta water and ¼ cup grated Parmesan, mixing until lightly creamy and well coated.\r\n9. Turn off the heat, drizzle with a little olive oil, adjust seasoning, and garnish with fresh basil before serving warm.\r\n\r\n\r\n', 'https://thecozycook.com/wp-content/uploads/2024/02/Pasta-Primavera-f.jpg', '2025-11-26 07:51:00', 'primavera.php', 'Italian'),
(22, 'admin@veggiedelights.com', 'Mushroom Risotto', 'Italian rice cooked slowly with mushrooms, butter, and parmesan for a rich and creamy flavor.', 'Arborio rice, mushrooms, vegetable broth, butter, parmesan cheese, onion, garlic, olive oil, white wine, salt, pepper', '1.Warm 4 cups of vegetable stock in a saucepan and keep it simmering on low heat.\r\n\r\n2.Heat 1–2 tbsp oil in a pan and cook the sliced mushrooms undisturbed until browned, then remove and keep aside.\r\n\r\n3.In the same pan melt 2 tbsp butter, add one finely chopped onion and cook until soft and translucent.\r\n\r\n4.Stir in 3–4 minced garlic cloves and cook for 30 seconds until fragrant.\r\n\r\n5.Add 1 cup Arborio rice and stir constantly for 1–2 minutes so each grain is glossy and coated.\r\n\r\n6.Pour in ¼ cup white wine (optional) and stir until it is fully absorbed by the rice.\r\n\r\n7.Add the warm stock one ladle at a time, stirring gently and allowing the rice to absorb the liquid before adding the next, continuing for about 18–22 minutes until al dente and creamy.\r\n\r\n8.Return the cooked mushrooms to the rice, stir in 1 tbsp butter and ½ cup grated Parmesan, adjust salt and pepper, and remove from heat.\r\n\r\n9.Let the risotto rest for 1–2 minutes, then plate immediately and garnish with chopped parsley and extra Parmesan', 'https://cdn.loveandlemons.com/wp-content/uploads/2023/01/mushroom-risotto.jpg', '2025-11-26 07:51:00', 'risotto.php', 'Italian'),
(23, 'Sujay@yahoo.com', 'Aloo Gobi', 'Aloo Gobi is a popular North Indian dry curry made with potatoes, cauliflower, and aromatic spices. It’s mildly spiced, flavorful, and goes perfectly with roti or rice.', 'Potatoes, Cauliflower, Oil, Cumin seeds, Onion, Tomatoes, Green chilies, Ginger-garlic paste, Turmeric powder, Coriander powder, Cumin powder, Garam masala, Red chili powder, Salt, Fresh coriander leaves\r\n', '1.Heat oil: In a pan, heat oil on medium heat. Add cumin seeds and let them splutter.\r\n\r\n2.Sauté onions: Add chopped onions and sauté until golden brown.\r\n\r\n3.Add ginger-garlic and spices: Mix in ginger-garlic paste and green chilies. Sauté for 1–2 minutes.\r\n\r\n4.Add tomatoes & spices: Add chopped tomatoes, turmeric, coriander, cumin, and red chili powder. Cook until tomatoes soften and oil separates.\r\n\r\n5.Cook potatoes & cauliflower: Add diced potatoes and cauliflower florets. Mix well to coat with spices.\r\n\r\n6.Simmer: Add a splash of water, cover, and cook on low heat for 15–20 minutes, stirring occasionally, until vegetables are tender.\r\n\r\n7.Finish with garam masala: Sprinkle garam masala and chopped coriander. Mix gently.\r\n\r\n8.Serve hot: Garnish with more coriander leaves if desired. Serve with roti, paratha, or rice.', 'https://niksharmacooks.com/wp-content/uploads/2022/11/AlooGobiDSC_5234.jpg', '2025-11-26 08:40:37', 'aloo_gobi.php', 'North Indian'),
(24, 'mahendra@yahoo.com', 'Tiramisu', 'A classic Italian dessert made with layers of coffee-soaked ladyfingers and creamy mascarpone cheese, dusted with cocoa powder.', '3 large eggs, separated\r\n100 g (1/2 cup) granulated sugar,\r\n250 g (1 cup) mascarpone cheese,\r\n200 ml (3/4 cup) heavy cream,\r\n1 tsp vanilla extract,\r\n200 g (about 24) ladyfinger biscuits (savoiardi),\r\n200 ml strong brewed coffee, cooled\r\n2 tbsp coffee liqueur (optional)\r\nUnsweetened cocoa powder, for dusting\r\nDark chocolate shavings (optional)', '1. Prepare the cream: Whisk egg yolks with sugar until pale and creamy. Add mascarpone cheese and vanilla extract; mix until smooth.\r\n2. Whip cream: In a separate bowl, whip the heavy cream until stiff peaks form. Gently fold whipped cream into the mascarpone mixture until combined.\r\n3. Coffee dip: Mix coffee with coffee liqueur (if using). Quickly dip each ladyfinger into the coffee, making sure not to soak them.\r\n4. Layer dessert: Arrange a layer of soaked ladyfingers at the bottom of your dish. Spread half of the mascarpone cream over the ladyfingers. Repeat with another layer of dipped ladyfingers and the remaining cream.\r\n5. Chill & serve: Cover and refrigerate for at least 4 hours (or overnight). Before serving, dust with cocoa powder and sprinkle with chocolate shavings.', 'https://media.istockphoto.com/id/517368976/photo/slice-of-dessert.jpg?s=612x612&w=0&k=20&c=fS6QBm88-tmGNHbl7ePpHiysNsCgBJ8D1ZPtabLwH-0=', '2025-11-26 14:57:37', 'tiramisu.php', 'Italian'),
(25, 'mahendra@yahoo.com', 'Kesaribath', 'Kesaribath is a rich, aromatic South Indian sweet made from rava, ghee, saffron, and sugar.\r\n', 'rava (semolina), ghee, sugar, water, saffron strands, milk (optional), cardamom powder, cashews, raisins, food color (optional)', '1.ghee in a pan and roast rava on low flame until aromatic.\r\n\r\n2.In another pot, boil water and add saffron soaked in a little warm milk.\r\n\r\n3.Add the roasted rava slowly into the boiling saffron water while stirring to avoid lumps.\r\n\r\n4.Cook until the rava absorbs the water and becomes soft.\r\n\r\n5.Add sugar and mix continuously; the mixture will loosen and then thicken again.\r\n\r\n6.Stir in cardamom powder, cashews, and raisins fried in ghee.\r\n\r\n7.Cook for another 2–3 minutes until it reaches a glossy, soft consistency.\r\n\r\n8.Serve warm and enjoy!', 'https://spicesandaromas.com/wp-content/uploads/2020/03/kesari-bath-sheera.jpg', '2025-11-27 14:14:39', 'kesaribath.php', 'South Indian'),
(26, 'Sujay@yahoo.com', 'Rava Idli (Semolina Steamed Cakes)', 'Rava idly is a soft, fluffy South Indian steamed breakfast made from roasted semolina, yogurt, and mild spices.', 'rava (semolina), curd (yogurt), water, salt, fruit salt (eno), oil or ghee, mustard seeds, curry leaves, green chilies, ginger, urad dal, chana dal, cashews, coriander leaves', '1.Heat oil or ghee, add mustard seeds, urad dal, chana dal, cashews, curry leaves, chilies, and ginger; sauté until golden.\r\n\r\n2.Add rava and roast on medium flame for 3–4 minutes until aromatic.\r\n\r\n3.Let it cool, then mix with curd, salt, and a little water to make a thick batter.\r\n\r\n4.Rest the batter for 10–15 minutes; adjust consistency if needed.\r\n\r\n5.Just before steaming, add eno and mix gently (batter will rise).\r\n\r\n6.Pour into greased idly moulds and steam for 10–12 minutes.\r\n\r\n7.Serve hot with coconut chutney and sambar!', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_ID1DrQJuqDZROzMIeoyxuZLG7Ce6KNGFtQ&s', '2025-11-27 14:31:14', 'rava_idli_semolina_steamed_cakes_.php', 'South Indian'),
(27, 'Sujay@yahoo.com', 'Poori', 'Crispy, puffed Indian fried bread made from whole wheat flour—perfect with potato masala or chole.', 'whole wheat flour, salt, water, oil (for kneading), oil (for deep frying)', '1.Mix wheat flour, salt, and a little oil; add water gradually and knead into a tight, smooth dough.\r\n\r\n2.Rest the dough for 10–15 minutes.\r\n\r\n3.Divide into small balls and roll each one into a small round poori (not too thin).\r\n\r\n4.Heat oil well and slide in the pooris one at a time.\r\n\r\n5.Press gently with a ladle to help them puff up.\r\n\r\n6.Fry until golden, then drain on tissue paper.\r\n\r\n7.Serve hot with potato masala, chole, or any curry!', 'https://www.awesomecuisine.com/wp-content/uploads/2020/03/poori-masala-kizhangu.jpg', '2025-11-27 14:35:46', 'poori.php', 'South Indian'),
(28, 'nikitha@gmail.com', 'Upma', 'A quick, savory South Indian breakfast made from roasted semolina cooked with veggies and aromatic spices.', 'rava (semolina), oil or ghee, mustard seeds, urad dal, chana dal, green chilies, ginger, curry leaves, onion, vegetables (optional), water, salt, coriander leaves, lemon juice (optional)', '1.Roast rava in a pan until aromatic; set aside.\r\n\r\n2.Heat oil, add mustard seeds, urad dal, chana dal, chilies, ginger, and curry leaves; sauté until golden.\r\n\r\n3.Add onions (and optional veggies) and sauté until soft.\r\n\r\n4.Pour in water, add salt, and bring to a boil.\r\n\r\n5.Slowly add roasted rava while stirring to avoid lumps.\r\n\r\n6.Cook until the mixture thickens and rava absorbs water.\r\n\r\n7.Add coriander leaves and optional lemon juice; mix gently.\r\n\r\n8.Serve hot!', 'https://www.sharmispassions.com/wp-content/uploads/2013/04/WheatRavaUpma4.jpg', '2025-11-27 14:43:04', 'upma.php', 'South Indian'),
(29, 'nikitha@gmail.com', 'Pongal', 'A warm, comforting South Indian dish made from rice and moong dal, flavored with ghee, pepper, and cumin.', 'rice, moong dal, water, salt, ghee, black pepper, cumin seeds, ginger, curry leaves, cashews', '1.Dry roast moong dal lightly until aromatic.\r\n\r\n2.Wash rice and dal together and pressure cook with water and salt until soft and mushy.\r\n\r\n3.Heat ghee in a pan, add cumin, pepper, ginger, curry leaves, and cashews; fry until golden.\r\n\r\n4.Pour this tempering over the cooked rice-dal mixture.\r\n\r\n5.Mix well and cook for 2–3 minutes until creamy.\r\n\r\n6.Serve hot with chutney!', 'https://cdn2.foodviva.com/static-content/food-images/south-indian-recipes/ven-pongal/ven-pongal.jpg', '2025-11-27 14:46:38', 'pongal.php', 'South Indian'),
(30, 'nikitha@gmail.com', 'Shavige Payasam', 'A light, creamy South Indian dessert made with roasted vermicelli simmered in milk, sugar, and flavored with cardamom.', 'vermicelli (shavige), ghee, milk, sugar, cardamom powder, cashews, raisins, saffron (optional)', '1.Heat ghee and roast vermicelli until golden; set aside.\r\n\r\n2.In a pot, boil milk and add the roasted vermicelli.\r\n\r\n3.Cook on medium flame until soft and thickened.\r\n\r\n4.Add sugar and mix until fully dissolved.\r\n\r\n5.Stir in cardamom powder, saffron (optional), and fried cashews & raisins.\r\n\r\n6.Simmer for 2–3 minutes and serve warm or chilled!', 'https://kannada.cdn.zeenews.com/kannada/sites/default/files/2023/08/02/325518-shavige-payasa.png', '2025-11-27 14:50:41', 'shavige_payasam.php', 'South Indian'),
(31, 'nikitha@gmail.com', 'Chilli Paneer', 'A popular Indo-Chinese dish made with crispy paneer tossed in spicy, tangy sauces and sautéed veggies.', 'paneer cubes, cornflour, maida, salt, pepper, oil, garlic, ginger, green chilies, onion, capsicum, soy sauce, tomato ketchup, chili sauce, vinegar, spring onion', '1.Mix paneer with salt, pepper, cornflour, and a little water; coat well and shallow or deep fry until golden.\r\n\r\n2.Heat oil, sauté garlic, ginger, and green chilies.\r\n\r\n3.Add onion and capsicum and stir-fry on high flame.\r\n\r\n4.Add soy sauce, chili sauce, tomato ketchup, vinegar, salt, and pepper; mix well.\r\n\r\n5.Add the fried paneer and toss until coated with the sauce.\r\n\r\n6.Garnish with spring onions and serve hot!', 'https://spicecravings.com/wp-content/uploads/2022/01/Chilli-Paneer-Featured-2.jpg', '2025-11-27 15:12:57', 'chilli_paneer.php', 'Chinese'),
(32, 'Roopa@gmail.com', 'Lemon Ricotta Cheesecake', 'A light, refreshing Italian cheesecake made with ricotta cheese, lemon zest, and a soft, creamy texture.', 'ricotta cheese, sugar, eggs, lemon zest, lemon juice, vanilla extract, flour (optional), powdered sugar (for dusting)', '1.Whisk ricotta and sugar until smooth and creamy.\r\n\r\n2.Add eggs one by one, mixing gently.\r\n\r\n3.Add lemon zest, lemon juice, and vanilla; mix well.\r\n\r\n4.Add a spoon of flour if you want a firmer texture.\r\n\r\n5.Pour into a greased baking tin.\r\n\r\n6.Bake at 160°C for 45–50 minutes until set and lightly golden.\r\n\r\n7.Cool completely and dust with powdered sugar before serving.', 'https://recipesblob.oetker.co.uk/assets/65f7e3f018964d968e417f1a0f224da1/750x910/lemon-cheesecake.jpg', '2025-11-27 15:28:51', 'lemon_ricotta_cheesecake.php', 'Italian'),
(33, 'naresh@gmail.com', 'Crispy Corn', 'Crispy Corn is a crunchy, spicy Indo-Chinese snack made by frying coated sweet corn and tossing it in flavourful garlic-chilli seasoning.', 'Sweet corn (1 cup, boiled), cornflour (3 tbsp), rice flour or maida (1 tbsp), salt, black pepper powder, red chilli powder, chaat masala, oil (for frying), chopped garlic (1 tbsp), chopped onions (2 tbsp), chopped capsicum (2 tbsp), green chillies (2, slit), spring onion greens, soy sauce (1 tsp), tomato ketchup (1 tbsp), lemon juice (½ tbsp).', '1.Boil the sweet corn for 3–4 minutes, drain completely, and pat dry.\r\n\r\n2.Add cornflour, rice flour/maida, salt, pepper, and chilli powder to the corn and mix well until coated.\r\n\r\n3.Heat oil and deep-fry the coated corn on medium flame until golden and crispy; remove and keep aside.\r\n\r\n4.In a separate pan, heat 1 tbsp oil and sauté garlic, green chillies, onions, and capsicum for 1 minute.\r\n\r\n5.Add soy sauce, ketchup, a pinch of salt, and pepper; mix well.\r\n\r\n6.Add the fried crispy corn and toss on high flame for 30 seconds.\r\n\r\n7.Switch off the flame, sprinkle chaat masala and lemon juice.\r\n\r\n8.Garnish with spring onion greens and serve hot.', 'https://i.ytimg.com/vi/XawYJxlkDzM/sddefault.jpg', '2025-11-29 05:37:46', NULL, 'Chinese'),
(34, 'kavyashreedm@gmail.com', 'Sabudhana Vada', 'A crispy and soft Maharashtrian snack made from sago and potato, perfect for fasting or as a tea-time treat.', 'sabudhana (sago), boiled potato, green chilies, cumin seeds, roasted peanuts, coriander leaves, salt, oil', '1.Soak sabudhana in water for 4–5 hours or overnight, then drain excess water.\r\n\r\n2.Prepare mixture: In a bowl, combine soaked sabudhana, mashed potato, chopped green chilies, cumin seeds, crushed roasted peanuts, chopped coriander leaves, and salt to form a dough.\r\n\r\n3.Shape vadas: Divide the mixture into small portions and flatten each into a round disc.\r\n\r\n4.Fry vadas: Heat oil in a pan and deep-fry the discs on medium heat until golden brown and crispy, turning occasionally.\r\n\r\n5.Serve: Remove from oil, drain excess, and serve hot with chutney.', 'https://vegecravings.com/wp-content/uploads/2017/07/sabudana-vada-recipe-step-by-step-instructions.jpg', '2025-12-16 05:40:41', NULL, 'North Indian');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `profile_pic` varchar(255) DEFAULT 'default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `name`, `email`, `password`, `security_question`, `security_answer`, `role`, `profile_pic`, `created_at`) VALUES
(1, 'Sujay Bhat', 'Sujay@yahoo.com', '$2y$10$wENPgkvcFlF5klSrEvRDEOvuJvEWZi6ay9ouhRbm4ijUdODzieRdG', 'What is your favorite vegetable?', 'onion', 'user', 'IMG_1763992633.jpeg', '2025-11-24 13:57:13'),
(2, 'Roopa Rao', 'Roopa@gmail.com', '$2y$10$b9k3ZDe8wbxhQplwAB1HOOhaDnEuWZZ9tD5Fo0SF5iCG/PcZvb8p2', 'What city were you born in?', 'Bengaluru', 'user', '', '2025-11-24 15:01:38'),
(3, 'Rekha Purohit', 'rekha@gmail.com', '$2y$10$bPpmz16PDDkmJNGIKF3K7ubqYMC8ZMrpN9fgnJ6q.NtuhWBfqkT3G', 'What is your favorite vegetable?', 'Carrots', 'user', '', '2025-11-25 15:21:14'),
(4, 'Rajesh nayak', 'Rajesh@yahoo.com', '$2y$10$C2NJBxP/gmFO4pFGWpmQ1OMKSP6p2no8fm2/Oq8TPolM9183yDhY6', 'What city were you born in?', 'Bengaluru', 'user', 'IMG_1764162368.jpeg', '2025-11-26 13:06:08'),
(5, 'Nikitha Jain', 'nikitha@gmail.com', '$2y$10$DbRLmBXScuZjqM/9v1lLOOPjfOeObev39nvmVLrDO5WDzSP9NX0ay', 'What is your favorite vegetable?', 'Beans', 'user', '', '2025-11-26 14:44:35'),
(6, 'Mahendra Sharma', 'mahendra@yahoo.com', '$2y$10$t8TN3aOwo0V1Wr.uATPdLOjRwypsq9Q7USQ7BelTIxONlkgog0L4O', 'What is your favorite vegetable?', 'Beans', 'user', 'IMG_1764168612.jpeg', '2025-11-26 14:50:12'),
(7, 'Naresh Gupta', 'naresh@gmail.com', '$2y$10$DXSxpyHisrgS8kJGnTGnSelnsY8iNJrrqWsVq.d9Wozi9YiXkzfoi', 'What is your pet’s name?', 'Blacky', 'user', 'IMG_1764393976.jpeg', '2025-11-29 05:26:16'),
(8, 'kavya', 'kavyashreedmmohan@gmail.com', '$2y$10$q2UZRSR8YAspksoE1FloieEdrPpCucGSRbmnzenhXrfffJRAtruzG', 'What is your favorite vegetable?', 'carrot', 'user', '', '2025-12-15 17:28:22'),
(9, 'kavya', 'kavyashreedm@gmail.com', '$2y$10$knPTRy.5PvKJqb6VJ/.4s.CzfSlTlURwkdjDnTWPM/wNZkTpGIE3W', 'What is your favorite vegetable?', 'carrot', 'user', '', '2025-12-15 17:30:20'),
(10, 'Admin', 'admin@veggiedelights.com', '$2y$10$tgVYUu9FeCeZ1r9EQ7qvNO4nkDJnPbNDcXQ93TkK9CBIqPecONoQa', '', '', 'admin', 'default.png', '2025-12-16 10:03:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`recipe_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
