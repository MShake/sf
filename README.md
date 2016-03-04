lolochat
========
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d7a3b222-449e-4bb1-8c3a-b58d29aeef7a/big.png)](https://insight.sensiolabs.com/projects/d7a3b222-449e-4bb1-8c3a-b58d29aeef7a)
[![Build Status](https://travis-ci.org/MShake/sf.svg?branch=master)](https://travis-ci.org/MShake/sf)
<br /><br />

A Symfony project created on March 1, 2016, 2:12 pm.<br /><br />
<b>Project created by © Grimlou, Juanito, Panini, Lolofeuj</b><br /><br />

<h1>First Installation</h1>
<h2>Step 1</h2>
`composer install`<br />
<h2>Step 2</h2>
`php bin/console doctrine:database:create`<br />
<h2>Step 3</h2>
`php bin/console assets:install`<br />
<h2>Step 4</h2>
`php bin/console doctrine:schema:update --force --dump-sql`<br />
<h2>Step 5</h2>
`php bin/console doctrine:fixtures:load`<br />
<br /><br />
<b>Have Fun !</b>
<br /><br />


<h1>When pulling the project always do :</h1>
`composer update`<br />
`php bin/console doctrine:schema:update --force --dump-sql`<br />
`php bin/console doctrine:fixtures:load`<br />
`php bin/console assets:install`
<br /><br />
