<?php

// incluindo o autoload de classes

require 'vendor/autoload.php';

// importando a classe Manager do Intervention Image

use Intervention\Image\ImageManager;

// instanciando um gerenciador de imagem com a "engine" escolhida (GD no caso)

$manager = new ImageManager(array('driver' => 'GD'));

// lendo a image1.png, redimencionando para 300x200 e salvando como image2.png

$image = $manager->make('media/image1-1.png')->resize(300, 200)->save('image2.png');
