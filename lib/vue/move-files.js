import fs from 'fs';

fs.copyFile('../index.example.php', '../../public/index.php', function () {});
fs.rename('../../public/index.html', '../views/index.twig', function () {})