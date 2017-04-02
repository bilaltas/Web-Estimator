<?php

/* =========================
	MAIN CHOICES
========================= */
$mainChoices = array(
	'website' => array(
		'NEW WEBSITE',
		array(
			'ecommerce' => 'E-Commerce',
			'_news' => 'News',
			'_blog' => 'Personal Blog',
			'_portfolio' => 'Portfolio',
			'_promotion' => 'Promotion'
		)
	),

	'feature' => array(
		'NEW FEATURE FOR CURRENT WEBSITE',
		array(
			'_seo' => 'Search Engine Optimization (SEO)',
			'_socialmedia' => 'Social Media Management',
			'_logo' => 'Logo Design',
			'_marketing' => 'Marketing & Advertisement',
			'_backup' => 'Auto/Cloud Backup',
			'_security' => 'Extra Security',
			'_speed' => 'Speed Optimization',
			'_newsletter' => 'Newsletter',
			'_chat' => 'Live Support Chat Feature',
			'_maintenance' => 'Periodic Maintenance & Updates',
			'_content' => 'Content Writing',
			'_custom' => 'Custom Requests'
		)
	)
);


// Define step types
$steps = array(
	'website',
	'feature'
);

/* =========================
	NEW WEBSITE STEPS
========================= */

// E-Commerce specific steps
$steps['website']['ecommerce'] = array(
	'website' => 'Website Concept',
	'domain' => 'Current Domain Information',
	'server' => 'Current Server Information',
	'static_pages' => 'Static Pages',
	'dynamic_pages' => 'Dynamic Pages',
	'ecommerce_products' => 'E-Commerce Products',
	'ecommerce_images' =>   'Product Images',
	'ecommerce_payment' =>  'E-Commerce Payment Methods',
	'additional' => 'Additional Features and Services',
	'results' => 'Results Page'
);

/* =========================
	NEW FEATURE STEPS - NOT DONE
========================= */

?>