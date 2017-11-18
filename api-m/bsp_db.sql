SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsp_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `bsp_servers`
--
USE `bsp_db`;

CREATE TABLE `bsp_servers` (
  `id` bigint(20) NOT NULL,
  `ip` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `bsp_user`
--

CREATE TABLE `bsp_user` (
  `id` bigint(20) NOT NULL,
  `port` int(11) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `used` bigint(20) NOT NULL,
  `total` bigint(20) NOT NULL,
  `due_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bsp_servers`
--
ALTER TABLE `bsp_servers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Indexes for table `bsp_user`
--
ALTER TABLE `bsp_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `port` (`port`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `bsp_servers`
--
ALTER TABLE `bsp_servers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000014;

--
-- 使用表AUTO_INCREMENT `bsp_user`
--
ALTER TABLE `bsp_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
