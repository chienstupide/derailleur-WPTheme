<?php

// require 'vendor/autoload.php';
use Timber\Timber;

Timber::init();
// dd($wpdb);
$context = Timber::context();
// dd($context);
// context contient toutes les variables globales de Timber

$posts = Timber::get_posts( [
      'post_type' => 'post',
      'post_author' => 1,
    // 'category_name' => 'sports',
  ] );


$posts_a_la_une = Timber::get_posts([
    'post_type' => 'post',
    'category_name' => 'a_la_une',
]);
$posts_agenda = Timber::get_posts([
    'post_type' => 'post',
    'category_name' => 'agenda',
]);
$posts_activite = Timber::get_posts([
    'post_type' => 'post',
    'category_name' => 'activite',
]);
$posts_presentation = Timber::get_posts([
    'post_type' => 'post',
    'category_name' => 'presentation',
]);
$posts_lien = Timber::get_posts([
    'post_type' => 'post',
    'category_name' => 'lien',
]);

$presentation_thumbail = Timber::get_image($posts_presentation[0]->thumbnail_id);

$menu = Timber::get_menu('primary');
$context['menu'] = $menu;
 
// $context['posts'] = $posts;
$context['posts_a_la_une'] = $posts_a_la_une;
$context['posts_agenda'] = $posts_agenda;
$context['posts_activite'] = $posts_activite;
$context['presentation_thumbail'] = $presentation_thumbail;
$context['posts_lien'] = $posts_lien;

$context['derailleur_contact_phone'] = get_option('derailleur_contact_phone');
$context['derailleur_contact_address'] = get_option('derailleur_contact_address');
$context['derailleur_contact_email'] = get_option('derailleur_contact_email');

$context['test'] = 'Hello Timber!';

Timber::render('views/pages/index.twig', $context);
