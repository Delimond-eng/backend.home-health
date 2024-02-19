-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 15 fév. 2024 à 10:32
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `home_health`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_fullname` varchar(255) NOT NULL,
  `doctor_phone` varchar(255) NOT NULL,
  `doctor_hospital` varchar(255) NOT NULL,
  `doctor_order_num` varchar(255) NOT NULL,
  `doctor_status` varchar(255) NOT NULL DEFAULT 'actif',
  `doctor_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `doctors`
--

INSERT INTO `doctors` (`id`, `doctor_fullname`, `doctor_phone`, `doctor_hospital`, `doctor_order_num`, `doctor_status`, `doctor_created_at`) VALUES
(1, 'Gaston Delimond', '+243813748833', 'HJ hospital', 'A039403202', 'actif', '2024-02-15 09:00:08');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_02_12_114032_create_doctors_table', 1),
(3, '2024_02_12_131717_create_nurses_table', 1),
(4, '2024_02_12_132726_create_visits_table', 1),
(5, '2024_02_12_133040_create_patient_treatment_table', 1),
(6, '2024_02_12_133515_create_visit_delegates_table', 1),
(7, '2024_02_12_140019_create_patients_table', 1),
(8, '2024_02_13_065528_create_users_table', 1),
(9, '2024_02_13_173858_create_visit_reports_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `nurses`
--

CREATE TABLE `nurses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nurse_fullname` varchar(255) NOT NULL,
  `nurse_phone` varchar(255) DEFAULT NULL,
  `nurse_status` varchar(255) NOT NULL DEFAULT 'actif',
  `nurse_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `doctor_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `nurses`
--

INSERT INTO `nurses` (`id`, `nurse_fullname`, `nurse_phone`, `nurse_status`, `nurse_created_at`, `doctor_id`) VALUES
(1, 'Makumba Tania', '+24381374803', 'actif', '2024-02-15 09:00:36', 1);

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_fullname` varchar(255) NOT NULL,
  `patient_phone` varchar(255) NOT NULL,
  `patient_address` varchar(255) NOT NULL,
  `patient_gender` varchar(255) NOT NULL,
  `patient_status` varchar(255) NOT NULL DEFAULT 'actif',
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `patient_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`id`, `patient_fullname`, `patient_phone`, `patient_address`, `patient_gender`, `patient_status`, `doctor_id`, `patient_created_at`) VALUES
(1, 'Kubi Kayembe Flory', '+24381779880', '04, Bimuala, RTNC, Lingwala Kinshasa', 'M', 'actif', 1, '2024-02-15 09:01:31'),
(2, 'Mukantu Djo perkins', '+24381779000', '04, Modiaba, Lueno, Kinshasa Gombe', 'M', 'actif', 1, '2024-02-15 09:07:52');

-- --------------------------------------------------------

--
-- Structure de la table `patient_treatments`
--

CREATE TABLE `patient_treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_treatment_libelle` varchar(255) NOT NULL,
  `patient_treatment_status` varchar(255) NOT NULL DEFAULT 'actif',
  `visit_id` bigint(20) UNSIGNED NOT NULL,
  `patient_treatment_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patient_treatments`
--

INSERT INTO `patient_treatments` (`id`, `patient_treatment_libelle`, `patient_treatment_status`, `visit_id`, `patient_treatment_created_at`) VALUES
(1, 'Injection mepro 5ml dans les muscles fessiers', 'actif', 1, '2024-02-15 09:02:02'),
(2, 'Solution buvable de cirop orale', 'actif', 1, '2024-02-15 09:02:03'),
(3, 'Perfusion de la solution anti paludeen', 'actif', 2, '2024-02-15 09:09:20'),
(4, 'Injection anti-fievre', 'actif', 2, '2024-02-15 09:09:20');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_type` varchar(255) DEFAULT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `profile_id`, `profile_type`, `user_created_at`) VALUES
(1, 'gastondelimond@gmail.com', '$2y$10$vBpFyuy.l0n6/MDLngtveedtNvzpUNCkS2GOpysGeyLp6UGuzbEDy', 1, 'App\\Models\\Doctor', '2024-02-15 09:00:08'),
(2, 'taniamakumba@gmail.com', '$2y$10$GivuTJSuiMC9pmIhcnkUWe/mDdKYCDlHWmIHcfjAefdUzkIWw.kOq', 1, 'App\\Models\\Nurse', '2024-02-15 09:00:37');

-- --------------------------------------------------------

--
-- Structure de la table `visits`
--

CREATE TABLE `visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visit_date` timestamp NULL DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `nurse_id` bigint(20) UNSIGNED NOT NULL,
  `visit_status` varchar(255) NOT NULL DEFAULT 'pending',
  `visit_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `visits`
--

INSERT INTO `visits` (`id`, `visit_date`, `patient_id`, `nurse_id`, `visit_status`, `visit_created_at`) VALUES
(1, '2024-02-15 13:30:00', 1, 1, 'pending', '2024-02-15 09:02:02'),
(2, '2024-02-16 12:30:00', 2, 1, 'pending', '2024-02-15 09:09:20');

-- --------------------------------------------------------

--
-- Structure de la table `visit_delegates`
--

CREATE TABLE `visit_delegates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delegate_nurse_id` bigint(20) UNSIGNED NOT NULL,
  `visit_id` bigint(20) UNSIGNED NOT NULL,
  `visit_delegate_status` varchar(255) NOT NULL DEFAULT 'pending',
  `visit_delegate_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `visit_reports`
--

CREATE TABLE `visit_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visit_id` bigint(20) UNSIGNED NOT NULL,
  `nurse_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `report_status` varchar(255) NOT NULL DEFAULT 'actif',
  `report_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_doctor_order_num_unique` (`doctor_order_num`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `patient_treatments`
--
ALTER TABLE `patient_treatments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `visit_delegates`
--
ALTER TABLE `visit_delegates`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `visit_reports`
--
ALTER TABLE `visit_reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `nurses`
--
ALTER TABLE `nurses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `patient_treatments`
--
ALTER TABLE `patient_treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `visit_delegates`
--
ALTER TABLE `visit_delegates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `visit_reports`
--
ALTER TABLE `visit_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
