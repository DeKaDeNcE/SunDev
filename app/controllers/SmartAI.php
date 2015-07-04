<?php

$app->get('/smartai/available', function () use ($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	$entry = $manager->getAvailableEntry() + 1;
	return $app->redirect('/smartai/creature/entry/' . $entry);
});

// GET SPELL NAME
$app->get('/spell/{entry}/name', function ($entry) use ($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $manager->getSpellName($entry);
});

// GET QUEST NAME
$app->get('/quest/{entry}/name', function ($entry) use ($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $manager->getQuestName($entry);
});

// GET ITEM NAME
$app->get('/item/{entry}/name', function ($entry) use ($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $manager->getItemName($entry);
});

// SELECT SCRIPT
$app->get('/smartai', function () use ($app) {
	return $app['twig']->render('smartai/index.html.twig');
});

// GET NAMES
$app->get('/smartai/creature/entry/{entry}/name', function($entry) use($app) {
	$creature 	= new SUN\Domain\Creature(["entry" => $entry]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $manager->findCreatureEntryName($creature)->getName();
});

$app->get('/smartai/creature/guid/{guid}/name', function($guid) use($app) {
	$creature 	= new SUN\Domain\Creature(["guid" => $guid]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $manager->findCreatureGuidName($creature)->getName();
});

$app->get('/smartai/gameobject/entry/{entry}/name', function($entry) use($app) {
	$gameobject	= new SUN\Domain\Gameobject(["entry" => $entry]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $manager->findGOEntryName($gameobject)->getName();
});

$app->get('/smartai/gameobject/guid/{guid}/name', function($guid) use($app) {
	$gameobject	= new SUN\Domain\Gameobject(["guid" => $guid]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $manager->findGOGuidName($gameobject)->getName();
});

// GET CREATURE ENTRY SCRIPT
$app->get('/smartai/creature/entry/{entry}', function($entry) use($app) {
	$creature 	= new SUN\Domain\Creature(["entry" => $entry]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	$creature->setName($manager->findCreatureEntryName($creature)->getName());
	$lines		= $manager->getCreatureEntryScript($creature);

	return $app['twig']->render('smartai/creature/entry.html.twig',
		array(
			"lines" 	=> $lines,
			"creature" 	=> $creature,
			"events" 	=> $manager->getEvents(),
			"actions" 	=> $manager->getActions(),
			"targets" 	=> $manager->getTargets(),
		));
});

// GET CREATURE GUID SCRIPT
$app->get('/smartai/creature/guid/{guid}', function($guid) use($app) {
	$creature 	= new SUN\Domain\Creature(["guid" => $guid]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	$creature->setName($manager->findCreatureGuidName($creature)->getName());
	$lines		= $manager->getCreatureGuidScript($creature);

	return $app['twig']->render('smartai/creature/guid.html.twig',
		array(
			"lines" 	=> $lines,
			"creature" 	=> $creature,
			"events" 	=> $manager->getEvents(),
			"actions" 	=> $manager->getActions(),
			"targets" 	=> $manager->getTargets(),
		));
});

// GET GAMEOBJECT ENTRY SCRIPT
$app->get('/smartai/object/entry/{entry}', function($entry) use($app) {
	$go		 	= new SUN\Domain\Gameobject(["entry" => $entry]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	$go->setName($manager->findGOEntryName($go)->getName());
	$lines		= $manager->getGOEntryScript($go);

	return $app['twig']->render('smartai/go/entry.html.twig',
		array(
			"lines" 	=> $lines,
			"go" 		=> $go,
			"events" 	=> $manager->getEvents(),
			"actions" 	=> $manager->getActions(),
			"targets" 	=> $manager->getTargets(),
		));
});

// GET GAMEOBJECT GUID SCRIPT
$app->get('/smartai/object/guid/{guid}', function($guid) use($app) {
	$go		 	= new SUN\Domain\Gameobject(["guid" => $guid]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	$go->setName($manager->findGOGuidName($go)->getName());
	$lines		= $manager->getGOGuidScript($go);

	return $app['twig']->render('smartai/go/guid.html.twig',
		array(
			"lines" 	=> $lines,
			"go" 		=> $go,
			"events" 	=> $manager->getEvents(),
			"actions" 	=> $manager->getActions(),
			"targets" 	=> $manager->getTargets(),
		));
});

// GET CREATURE ENTRY SCRIPT
$app->get('/smartai/script/{script}', function($script) use($app) {
	$creature 	= new SUN\Domain\Creature(["entry" => substr($script, 0, -2)]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	$creature->setName($manager->findCreatureEntryName($creature)->getName());
	$lines		= $manager->getScript($script);

	return $app['twig']->render('smartai/script/script.html.twig',
		array(
			"lines" 	=> $lines,
			"script"	=> $script,
			"creature" 	=> $creature,
			"events" 	=> $manager->getEvents(),
			"actions" 	=> $manager->getActions(),
			"targets" 	=> $manager->getTargets(),
		));
});

// GET EVENTS
$app->get('/smartai/events', function() use($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $app['twig']->render('smartai/doc/events.html.twig', array( "events" => $manager->getEvents(),));
});

$app->get('/smartai/events/{id}', function($id) use($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return json_encode($manager->getEvent($id));
});

// GET ACTIONS
$app->get('/smartai/actions', function() use($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $app['twig']->render('smartai/doc/actions.html.twig', array( "actions" => $manager->getActions(),));
});

$app->get('/smartai/actions/{id}', function($id) use($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return json_encode($manager->getAction($id));
});

// GET TARGETS
$app->get('/smartai/targets', function() use($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return $app['twig']->render('smartai/doc/targets.html.twig', array( "targets" => $manager->getTargets(),));
});

$app->get('/smartai/targets/{id}', function($id) use($app) {
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	return json_encode($manager->getTarget($id));
});

// APPLY TEST SCRIPT
$app->post('/smartai/apply', function() use($app) {
	$script = json_decode($_POST['sql']);
	$manager= new \SUN\DAO\SmartAIDAO($app);
	if(isset($script->update)) {
		$manager->setQuery($script->update, 'test');
	}
	if(isset($script->delete)) {
		$manager->setQuery($script->delete, 'test');
	}
	if(isset($script->insert)) {
		$manager->setQuery($script->insert, 'test');
	}
	return "Success";
});

// VALIDATE SCRIPT
$app->post('/smartai/review/validate', function() use($app) {
	$script = json_decode($_POST['sql']);
	$review = json_decode($_POST['review']);
	$manager= new \SUN\DAO\SmartAIDAO($app);
	if(isset($script->update)) {
		$manager->setQuery($script->update, 'test');
		$manager->setQuery($script->update, 'world');
	}
	if(isset($script->delete)) {
		$manager->setQuery($script->delete, 'test');
		$manager->setQuery($script->delete, 'world');
	}
	if(isset($script->insert)) {
		$manager->setQuery($script->insert, 'test');
		$manager->setQuery($script->insert, 'world');
	}
	$manager->deleteReview($review->entryorguid, $review->source_type);
	return "Success";
});

// SEND REVIEW
$app->post('/smartai/review', function() use($app) {
	$script = json_decode($_POST['review']);
	$manager= new \SUN\DAO\SmartAIDAO($app);
	$manager->setReview($script->entryorguid, $script->source_type, $script->user);
	return "Success";
});

// CREATURE TEXT
$app->get('/smartai/creature/entry/{entry}/text', function($entry) use($app) {
	$creature 	= new SUN\Domain\Creature(["entry" => $entry]);
	$manager	= new \SUN\DAO\SmartAIDAO($app);
	$creature->setName($manager->findCreatureEntryName($creature)->getName());
	return $app['twig']->render('smartai/text.html.twig', array(
		"texts" 	=> $manager->getCreatureText($entry),
		"creature"	=> $creature,
	));
});