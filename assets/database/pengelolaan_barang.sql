-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Nov 2024 pada 09.09
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengelolaan_barang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `stok`) VALUES
(8, 'air galon', 5),
(9, 'infokus', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan_barang`
--

CREATE TABLE `permintaan_barang` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `id_pemohon` varchar(50) NOT NULL,
  `departemen` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `barang` varchar(255) NOT NULL,
  `signature` text NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') DEFAULT 'Pending',
  `catatan_admin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `permintaan_barang`
--

INSERT INTO `permintaan_barang` (`id`, `nama`, `id_pemohon`, `departemen`, `telepon`, `tanggal`, `barang`, `signature`, `status`, `catatan_admin`) VALUES
(6, 'nova', '2204010088', 'Mahasiswa', '081234567890', '2024-11-24 08:19:30', 'air galon', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAADICAYAAAAeGRPoAAAAAXNSR0IArs4c6QAAGx9JREFUeF7tnX/of1ddx5/qho4MNyuaOMuVo1+Ck/aHgTbFJKKGk4LmH6GSFCLOhEkGgUZSySpXEv7RzA3/2CDCiQaCwYotLCqmYb+1qTUalD8y01HOej/jnjo73c/7fe+55957znk/Lox9v5/PPee8zuN1vu/n+5zzOq/zOPFAAAIQgAAEINA8gcc13wM6AAEIQAACEICAEHQGAQQgAAEIQKADAgh6B06kCxCAAAQgAAEEnTEAAQhAAAIQ6IAAgt6BE+kCBCAAAQhAAEFnDEAAAhCAAAQ6IICgd+BEugABCEAAAhBA0BkDEIAABCAAgQ4IIOgdOJEuQAACEIAABBB0xgAEIAABCECgAwIIegdOpAsQgAAEIAABBJ0xAAEIQAACEOiAAILegRPpAgQgAAEIQABBZwxAAAIQgAAEOiCAoHfgRLoAAQhAAAIQQNAZAxCAAAQgAIEOCCDoHTiRLkAAAhCAAAQQdMYABCAAAQhAoAMCCHoHTqQLEIAABCAAAQSdMQABCEAAAhDogACC3oET6QIEIAABCEAAQWcMQAACEIAABDoggKB34ES6AAEIQAACEEDQGQMQgAAEIACBDggg6B04kS5AAAIQgAAEEHTGAAQgAAEIQKADAgh6B06c0YXbJb1S0qOSXizp/hlleRUCEIAABComgKBX7JwVTPuvqM6vSHoRor4CZaqEAAQgsAMBBH0H6Ds1+fzDrPy+pO3PS7piJ3toFgIQgAAEChJA0AvCrLyq35d0/YiNb5B0W+W2Yx4EIAABCJwggKCfzxCJl9sflnTl0PWPS7rmfDDQUwhAAAJ9EkDQ+/Rr2ivPwF8f/fBOSS89zMwvl/RFSV97HhjoJQQgAIF+CSDo/fo27tmDkp4Z/cB+/ylJbx9+9pCkq84DBb2EAAQg0CcBBL1Pv8a9spBb0MPzB5JeKMlBcv7z4yU54v2N7KX3PxjoIQQg0C8BBL1f34ae3TMsr4e/v+owW79j+ItF/V5Jlwyifmn/OOghBCAAgT4JIOh9+jXuVRwM94iky5Iux8fZwuy9fyr0EAIQgEBnBBD0zhyadOcWSbdGP3ufpBtHuhyOtJFspu/xQO8gAIGOCSDoHTv3sNT+gKRroy5efUj9+smRLnuW/v4h6p1jbH2PCXoHAQh0SgBB79SxQ7fi5fZTWeHipXeSzfQ9LugdBCDQIQEEvUOnDl26SdJdUfem7I+HADovvRMg1+/YoGcQgECHBBD0Dp06dClN9fpySXef6K5n6R+S9KThSJuPt/FAAAIQgEADBBD0BpyUaeLnhj3xUHyqr8PSu2fp75R0c2b7FIMABCAAgQ0JTP2Q39AkmipEIL0qdc4Segim85eCpxayh2ogAAEIQGBFAgj6inB3rDq9KnXK/nlq7n8OCWfeJulNO/aFpiEAAQhAYAIBBH0CpAZfSffPcwSds+nrOt5fuq4j3e66kKkdAudEAEHv09upoOceQwuz9JwvBH2SLdersCXyLkmvLlctNUEAAudKAEHv0/O5AXEpDd/IFjLNvUjS/X3i2rxX8ZYIiXw2x0+DEOiTAILep1+XBMSlRMJsn1l62bFyu6RnDTffla2Z2iAAgbMkgKD35/Y0IO5UhrgpBMLS+wuYpU/BxTsQgAAEtieAoG/PfO0Wf13S66JGSsyswyyd5eG1vUf9EIAABDIJIOiZ4Cou9mlJz4js+8SwtLvUZGbpSwlSHgIQgMCKBBD0FeHuVHUaEJcb4Z6aH/K8l1jC3wkNzUIAAhDolwCC3p9v44A4966kj8MsnaNW/Y0begQBCDROoOSHfeMoujA/DYgrfWuaj7G9XRKz9C6GC52AAAR6IoCg9+RN6TZJr4+69ElJVxfu4t8Ne/LM0guDpToIQAACSwgg6Evo1Vf2QUnPjMy6U9IrC5vpVYB7hzpJNlMYLtVBAAIQyCWAoOeSq7Ncun/+cwcz37KCqczSV4BKlRCAAASWEEDQl9Crq6xn5p6hx49n0D5DXvphll6aKPVBAAIQWEgAQV8IsKLinom/ObFnTf8yS6/I+ZgCAQhAYM0PfOhuS+DDkp4XNfmwpKetaAKz9BXhUjUEIACBuQQQ9LnE6n1/q/3zmACz9HrHA5ZBAAJnRgBB78PhY/vnawXExcSYpfcxfugFBCDQAQEEvQMnHrowtn++VkBcSizM0j8g6YY+cNILCEAAAu0RQNDb89mYxVsHxKWz9PsOAXle8v9erlftY0DRCwhAoD0CCHp7PhuzOA2IWyND3DFS4XrVEle19uERegEBCEBgYwII+sbAV2ouDYi7Q9KrVmrromq5XnVj4DQHAQhAICaAoLc/HvYKiEvJMUtvfyzRAwhAoGECCHrDzhtMd672dyfd2CogLqXHLL398UQPIACBRgkg6I06LjJ7z4C4lF64XpW99PbHFT2AAAQaI4CgN+awEXO3uDJ1DqXPSbpc0guIeJ+DjXchAAEILCOAoC/jV0PpByRdGxnivWwvue/1hFn6xyVds5cRtAsBCEDg3Agg6O17fI+Ur6eohWQzzNJPkeL3EIAABAoRQNALgdyxmlTQ9wqIixGwl77jgKBpCEDgPAkg6G37fezI2tWSnFhm74dZ+t4eoH0IQOCsCCDobbv7Jkl3JV2oxafM0tseW1gPAQg0RqCWD//GsFVj7i2Sbo2s2Trl6ykQPpfux9sA9596md9DAAIQgEA+AQQ9n10NJUN2tmDLFlemzul3sO9dkl49p+CMd93Gdx9uevszSS+cUY5XIQABCHRFAEFv253pkTXnb3ce95oez9K/KOmKFYwKy/qh6o9Ieu4K7VAlBCAAgeoJIOjVu+iogSGJS3iploC42Oi1guPSvoc2yVLX9pjGeghAIJMAgp4JrpJi8ZG12vbPA6I1guNul/TjR3zATL2SAYoZEIDAdgQQ9O1Yl24pPbJWq6C736WD48IlMIGpv9ikY/kNhxS0TovLAwEIQOAsCCDo7bo5zeFeW0BcTDbMqEsEx8Wz869IulTS8yXdK+mSqNGHJT2tXfdiOQQgAIF5BBD0ebxqevseSS+NDKoxIC7mVSI4zsJ9X1RpvF+e/s6vhax5Xs2oIdlOTeMHWyAAgc4IIOjtOvTBQ0S7hSo8tfsyHGGbk9/dIn2dpCslfb+k5yRL65+X9OQBQDw7n+pVz/DD40j8J0l6RNK/JBX4d/8a/cztpu/41x9LVghstx+vFvjPfzr0J/2/3/Hv/R7bBFO9x3sQgMBjCNQuArjrYgItBMTF1odl8T+Mzov7Z35eKelZg2D7775+9Zyf8IXBKxD+koDIn/NooO8QmEgAQZ8IqrLX0oC4va9MPYUnzLR/QdJlw7n0MLM+VXbs949KeoKkeIbt9zye/fPeHvczbBlY5H9P0t29dZL+QAACywgg6Mv47VXaM9p3R43XEhBn4f4hSc+T9HRJX39ktm2R8lK2Hy9fPxT1x3eph+Xr8CXAvw5BcBdxH9tHf4ekm4cCYUXgquHvXuZ+dlKZVwpse3jch/g59kUkZ9k/dwyZheMS/AXmS5I+M6TXfQvxArlIKQeBtgkg6G36L41w3ysgzhHnYak8XiYPYh0LtYP4/PzqIERPnID+36I98lNiHqr7arLP/oFDWtgbJrS11iv+EuE89iEw76L/u/3whchfIn54wdaDl+x/h+X6tVxKvRCokwCCXqdfTlmVRriX9GNYHg8zVwu2H89avdxrofl3SV8efu6fWYC87O/n1H7v1Mxx75V041CnxXzqBS/+EvF1EcCWk8zEMQbXS/LKggP35j5ha8LL9mFffoqv5rbD+xCAwI4ESgrBjt04u6bjCPexhDKeBfrD3/+FZeVYmL287Yjxseejww+97O3HueEdaX5KqKc6IZwjP5aiNY0RmDNO/+qwv/ztkTE1J9yZysy36v18ppgfayMIvbc+/EWIILypHuE9CFRIYM4HZYXmn61JcYT7P0n6W0lPGZanLYbey/Wyq58g0P6zZ/Y+MuVnz+tMg/0XHWGL87TPzfiWXljjvrY6zu1L92cs6t9ftBw74S8sYan+JwpeghPP6s0QsT/bjxs63gqBVj/oWuG71M6w/B2Wnr9tmHHH9X5q+FD/o0Mw2geHP9eeRCWkbh3LHBevPuRklvvwEJQXM6rx0ppjY8NCftdIP+zjn4m2N8bq8FZIvCzvs+2egR8LUJw7TkPUvVd6/CWx1OrNXDt4HwIQiAgg6PsPB394Oyr8pkPk+jcPszEvk4cPZSc68Wz7bwax/sIhovl1kdkhG9r+PZluQdhH97L+NVGxOK1r+ruptTsFbHov+l5Bg1NtDu/59MKbk4RB4XdT++Dl+VuThuOVkDjwzvvyFnpH7i+N0A8iz0x+rtd5HwKFCCDohUDOqMYC/iPD8S7vY4fl1P84HK/6bCTcnm2PnTVOI9xb9GEs3EFs4rvNl+Rh93E+C2P81HKs76Jh4i8gtjvO/Bfe9WqLxTwEHU4ZamkWwSkrHRZ6x1x83yEvfgmhjwX+1VOM5h0IQGAZgRbFYFmPtysdz7wt2rF42wp/4Dlrmj+wUwE6ZmUc9NVqwFcs3p7R/WyUo32JmJvbmKB7v9miWNvjMWJ70xWFYKdXKV6Sca7c9X5C0uOHihzw9g2ZnS+Rzc9j3f/9MUv0mV6gGAQmEEDQJ0Ca8EqIKn/rYe9zbJ/bH2ZOlOJ84Ev3HOOAsVqFagKy/0mKEgfv+UuPtxaumFL4yDtOrOJl6/ipMZPemJ3xrNyrCvZv7uNsekHQp57hn9NWfLzRM/oQjDmljvBldum/hSlt8Q4EzoYAgr7c1Y4yD5dwuDZ/WP3jEF3u5fE5S6VTrIkj3GtfSj7Wn7CPHt6xAC3dx3VdaRY9/6ymlYyLAt6CnUuFPPD0DP1bIgfMuRRnyjgce8cib/5zBB5xz6VNOQgkBBD0ZUMipBoNH0qedZUW8NjC9Hx2iwFxoT/xPrp/Nvd42kWe8/K1A+PipxZBH7OttJCHfnus+EtT+JK0R4KdIPA/OHI6Y8x/4d+Rt2D2PFa57FOB0hDYiQCCvhP4zGYdCe/jTOFp2X/x1oH7U3IGGa9iuG6vmDwjk3mpYml2vyDkdx7+4C+CazzpKkhJxnPtjWfvIcnRsTpC+loC6uaS5v2zJdCyIJyj07yn+oqh47XMOnP8kIq565gSiT21rTTKe09B95cwB76lKVu32C6Jgw/N7lh2vqlsS7wX9t9fO9wFcKzOEC3/G5x3L4GeOnomgKC35V0v53t/0s8WgrAGnVjMvc/7rUMjJQLigr3pWfQlUd65DLzk/Z4hi1tcx9Z+Sy+4mZoTP7ffc8vNFXefDGFJfi5l3j8LAgh6W26OZ55bC8NSUv7gfn907t575n7eHlVcakk4jSD3fqzr3uoZm5X79jPnH9j6+aXDRTo/HTW69+1zx/o/Z1meJfmtRxLtVU8AQa/eRY8xME7r2VJA3JiYh3Sh4fiaO1pqSTiNdP9LSd+1gasvShAzNcvbWiaufYRtDbuDuP9odIXuWDuOl/itQ5wEe+1reIE6myKAoLfjriU3kO3ZyzSQL41mXytwKw6M+/SQVnctDhcdRXOSnJevfPJhSp/S/Pa1/ru3iDuXg580EdOxfn71cBvdE6aA4B0I9Eyg1n/YPTPP7Vs4IufyrQTEpUFZY0fT0uNrpYLj4r16p9H9gVzwJ8qNZaZzEV+k8j0rtTm32pRxqa2NuXbE78cXD3n1xDnlc5/cvP+57VEOAlUSQNCrdMuoUfFeaAv751PEPHQ0nk2XCo5bO6PeRULuPtXon3hrw4xv2OisdyzcT59465sj231DXLj6988l/f1w9e91kp4t6RuHuAifr78odW47/7qxFAIFCCDoBSBuVEUc4b73nuypLse2+t1TSWNisfH7JWaQ8ZeEkqlfjwl5LUvsY/5JtzZKJ5rJEe5gp/f4/1nS2ziaduqfFr+HwMUEEPR2RkcskjXf7x3PjD3TeuOED+n0C8DS4Lg03qBEzvtjQu5RVKKNNUejBdfH+eL0uj6f/ysT/JMulb94SNTjBDFz9rpDPfF96syu1/Q6dZ8VAQS9HXcHoVx6G9laPU4j2ecsnafL8/7AX3JeOk2xukRsTwm5RfHHKgh8m+JX7zWHc//x++E2tCcetgvW+EyIl9C5kGWKp3gHAhkE1vjHm2EGRSYQCMvSNQbEpZHsOcu56bL7kll6emwtR9BPCbldVuNe+bGhFAdWThhyWa8g3lnYKASB5QQQ9OUMt6oh7AnXJiKl0oume7xzZvipD9IZ+hxmU4TcWwSOY/CXq9aecDQsZBxcYr/3vp3s6KEC1wIvsYOyEIDASstrgC1PIJ5Z1ZRQ5rPJ/eWngt+OkUmPVvndJcFx8bW2v3a4a91fPI49U4TcAm4hX/NGvfKjZ7zGHGEPt6F56Z5ELlt5inYgMJEAM/SJoHZ+LZ4F1+Azi4FFLSTzKHUMquSye5xMxYF5v3yBD9M0sWOvtbRPPneohuj0cBTMov2ZpJKPzQycm2sD70MAAgUI1CAOBbrRfRUhCnzJMnQpSGlE+hcO+difUqjysVvYcmfpvx3lTvdxqDclNqb77GNd8MzeKWpbXFov5BKqgQAEWiGAoLfhqSCiOcFmpXqYRrG73jGhXNLe2LJ7bua4WLDfJ+nGwTD3w39/6hFDEfIlXqQsBCCwCwEEfRfssxsN+8FzgrtmN3KkQCq0j0h6yUqZxtJl99y0nrGge2XjZYOov/5IP+88zMZdjgcCEIBAcwQQ9DZcFiLc98gQl0afLzlONoV2qWX3NPr+WNvO9f4altanuId3IACBWgkg6LV65rF2BUHf0l8+W/6eKLPY1KxvS4mme/SuL2fZ3dni/OXjm44Y5CQ9vkCFPfKlXqM8BCCwO4EtBWL3zjZqQDiytmVAXCqqW7Y9NrPOXXa3qLu+n5T0pMj/PUetNzrMMRsCEFhKAEFfSnD98iEL2xYZ4saC0tZeYh8jmO6j+53caHeX9Zei3zwcXXvyMNv3UTUeCEAAAl0RQNDrd2e4NnXNgK2xCPal+dSXkC217L7EBspCAAIQaIoAgl6/u4K4rZUhLr2wI2QD2/MWrJLL7vV7GAshAAEIFCCAoBeAuHIVDxzyZF+7Qppez8o/lOwt77G8fhG+0svuK7uJ6iEAAQjsSwBB35f/lNZ9Bv3yQxKXy6a8PPGddEnbUfSvlfTOieW3eC09Luc2c6Ldt7CVNiAAAQjsTgBB390FJw34sqS/PmQ3e+7JN0+/cNFe+TUVHt1i2f20P3kDAhCAwP8SQNDrHwyePZdYCh8LNNvyOFoO6XTZ3fv7l+ZURBkIQAACvRNA0Ov2cDiDvuRa0osypuWe7d6S2Niy+5Lja1vaTlsQgAAENiWAoG+Ke3Zjt0i6NTMgzl8GfOPYlSOtrnkEbnYnjxSo5Vx8yT5RFwQgAIFVCCDoq2AtVukdkl4xU9CdHc3lrh+xwpeqfEeF++UXAQsrFPHva98mKOZ8KoIABCAwhwCCPofW9u/+iaTvPMzSv2Zi08cuJCmxDz/RjKKvcXytKE4qgwAEeiWAoNftWZ9B/+iEKz2Pzcq3SBm7JkWyxq1Jl7ohAIFuCCDo9brSIv2gpKtPLJGPLUu7V1vdjrY2QY6vrU2Y+iEAgS4IIOj1uvGeYR/8iiMmjs1e/Xqry+sXdZXja/WOUyyDAAQqIYCgV+KIETN8/vx9km4c+d1Yghi/9qgkR8bfVm+3sizj+FoWNgpBAALnRABBr9fbnpV+LMoQ5yX4qyS9dSSC3UL+F5KeU293Flk2dnyNNLCLkFIYAhDojQCCXq9HvzQhf3sNN6NtQZDja1tQpg0IQKBpAgh6ve7zkvtFj4X8dy9Yjq+3R8ss4/jaMn6UhgAEOieAoNfr4JAc5lNDlPvDBwH/iKS76zV5Vcv+YdhyiBt5h6SbV22VyiEAAQg0QgBBb8RRmKn3jqxIsI/OwIAABCAwEEDQGQotEUjjClq4YKYlvtgKAQg0TABBb9h5Z2i6g+PuPUT6XxL1nTF8hgOBLkMAAv+fAB+GjIrWCKTJdLhOtTUPYi8EILAKAQR9FaxUuiKBdJbOPvqKsKkaAhBohwCC3o6vsPT/CMSZ49hHZ2RAAAIQmHnPNsAgUAuB+MIWn8m/tBbDsAMCEIDAXgSYoe9FnnaXEogTzbCPvpQm5SEAgeYJIOjNu/BsOxAHx7HsfrbDgI5DAAKBAILOWGiZALP0lr2H7RCAQFECCHpRnFS2MYE4OI5o943h0xwEIFAXAQS9Ln9gzTwCcXCcSzKe5/HjbQhAoCMCfAB25Mwz7Up8Kx3j+UwHAd2GAASY0TAG2ifwGkm/OKSEfVn73aEHEIAABPIIMKPJ40YpCEAAAhCAQFUEEPSq3IExEIAABCAAgTwCCHoeN0pBAAIQgAAEqiKAoFflDoyBAAQgAAEI5BFA0PO4UQoCEIAABCBQFQEEvSp3YAwEIAABCEAgjwCCnseNUhCAAAQgAIGqCCDoVbkDYyAAAQhAAAJ5BBD0PG6UggAEIAABCFRFAEGvyh0YAwEIQAACEMgjgKDncaMUBCAAAQhAoCoCCHpV7sAYCEAAAhCAQB4BBD2PG6UgAAEIQAACVRFA0KtyB8ZAAAIQgAAE8ggg6HncKAUBCEAAAhCoigCCXpU7MAYCEIAABCCQRwBBz+NGKQhAAAIQgEBVBBD0qtyBMRCAAAQgAIE8Agh6HjdKQQACEIAABKoigKBX5Q6MgQAEIAABCOQRQNDzuFEKAhCAAAQgUBUBBL0qd2AMBCAAAQhAII8Agp7HjVIQgAAEIACBqggg6FW5A2MgAAEIQAACeQQQ9DxulIIABCAAAQhURQBBr8odGAMBCEAAAhDII4Cg53GjFAQgAAEIQKAqAgh6Ve7AGAhAAAIQgEAeAQQ9jxulIAABCEAAAlURQNCrcgfGQAACEIAABPIIIOh53CgFAQhAAAIQqIoAgl6VOzAGAhCAAAQgkEcAQc/jRikIQAACEIBAVQQQ9KrcgTEQgAAEIACBPAIIeh43SkEAAhCAAASqIoCgV+UOjIEABCAAAQjkEUDQ87hRCgIQgAAEIFAVAQS9KndgDAQgAAEIQCCPAIKex41SEIAABCAAgaoIIOhVuQNjIAABCEAAAnkEEPQ8bpSCAAQgAAEIVEUAQa/KHRgDAQhAAAIQyCOAoOdxoxQEIAABCECgKgIIelXuwBgIQAACEIBAHgEEPY8bpSAAAQhAAAJVEUDQq3IHxkAAAhCAAATyCCDoedwoBQEIQAACEKiKwH8DByjF9u5P9t8AAAAASUVORK5CYII=', 'Disetujui', 'ambil airnya di wc'),
(7, 'hakim kai', '2204010045', 'Mahasiswa', '08228452544', '2024-11-24 08:35:05', 'air galon', 'data:image/png;base64,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LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAgh6GFdjKAQgAAEIeCaAoHv2LrZBAAIQgEAYAv8PH0WZ9rBV8ZIAAAAASUVORK5CYII=', 'Pending', 'ambil airnya di wc'),
(8, 'Yesi', '2201020055', 'Mahasiswa', '081234567881', '2024-11-24 08:46:28', 'infokus', 'data:image/png;base64,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', 'Disetujui', 'ambil di genteng');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
