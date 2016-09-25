# get-followers
Get Followers app direct access!

<p>App Name : Get Followers<br />Package Name : com.socialstar.getfollowers<br />Download Link : Search Google</p>

<h2>Setup</h2>
<p>Edit this line :</p>
<div class="highlight highlight-text-html-php"><pre>$session = "kIYOTwHI8lmr8qtzzgi6hzpju1a31qmxkwym89ua"; // Session
$atok = "3973759919.c6384ef.038912a7b15347419da7c8c68352fc66"; // Access token
$id = "3973759919"; // ID
$mid = "12761362"; // MID</pre></div>
<p>Anda harus merubahnya, untuk cara mendapatkan datanya anda bisa mendapatkannya dengan cara apapun, baik itu Reserver Enginnering atau yang lainnya.</p>
<h2>Examples</h2>
<h3>Add Coins</h3>
<div class="highlight highlight-text-html-php"><pre>$dat = getContents($id, $session);
foreach($dat['data']['followings'] as $gg){
    $fid = $gg['fid'];
    $f = follow($fid, $session, $atok);
}</pre></div>
<h3>Signup</h3>
<div class="highlight highlight-text-html-php"><pre>signup("2fc68314d01e468b8274baa22cf9df02");</pre></div>
<h3>Check Order</h3>
<div class="highlight highlight-text-html-php"><pre>orderchcek($id, $session);</pre></div>
<h3>Add Order</h3>
<div class="highlight highlight-text-html-php"><pre>addOrder(500, "3973759919", "galnetworks", $session);</pre></div>
<h2>Legal</h2>
<p>This code is in no way affiliated with, authorized, maintained, sponsored or endorsed by Instagram or any of its affiliates or subsidiaries. Use at your own risk.</p>
