<!DOCTYPE html>
<html>
<body>
    <form method="POST" action="populate_database.php">
        <p>Choose what kind of data to populate with</p>
        <div>
            <input type="checkbox" id="tables" name="tables" />
            <label for="tables">Database tables</label>
        </div>
        <div>
            <input type="checkbox" id="accounts" name="accounts" />
            <label for="accounts">Accounts</label>
        </div>
        <div>
            <input type="checkbox" id="blogs" name="blogs" />
            <label for="blogs">Blogs & everything else</label>
        </div>
        <input type="submit" name="populate" value="populate" />
    </form>
</body>



<?php
//found this code at https://www.php.net/manual/en/language.exceptions.php
//functions have to throw exceptions for catch to work, but many dont by default
//function exceptions_error_handler($severity, $message, $filename, $lineno) {
//    throw new ErrorException($message, 0, $severity, $filename, $lineno);
//}

//set_error_handler('exceptions_error_handler');
//


//requires
require_once('../php_classes/account_class.php');
require_once('../php_classes/blog_class.php');
require_once('../php_classes/blog_tag_class.php');
require_once('../php_classes/comment_class.php');
require_once('../php_classes/blog_report_class.php');
require_once('../php_classes/comment_report_class.php');

//variables
//sourced from https://simple.wikipedia.org/wiki/Wikipedia:List_of_1000_basic_words
$words = ["a","about","above","across","act","active","activity","add","afraid","after","again","age","ago","agree","air","all","alone","along","already","always","am","amount","an","and","angry","another","answer","any","anyone","anything","anytime","appear","apple","are","area","arm","army","around","arrive","art","as","ask","at","attack","aunt","autumn","away","baby","back","bad","bag","ball","bank","base","basket","bath","be","bean","bear","beautiful","bed","bedroom","beer","before","begin","behave","behind","bell","below","besides","best","better","between","big","bird","birth","birthday","bit","bite","black","bleed","block","blood","blow","blue","board","boat","body","boil","bone","book","border","born","borrow","both","bottle","bottom","bowl","box","boy","branch","brave","bread","break","breakfast","breathe","bridge","bright","bring","brother","brown","brush","build","burn","bus","business","busy","but","buy","by","cake","call","can","candle","cap","car","card","care","careful","careless","carry","case","cat","catch","central","century","certain","chair","chance","change","chase","cheap","cheese","chicken","child","children","chocolate","choice","choose","circle","city","class","clean","clear","clever","climb","clock","close","cloth","clothes","cloud","cloudy","coat","coffee","coin","cold","collect","color","comb","come","comfortable","common","compare","complete","computer","condition","contain","continue","control","cook","cool","copper","corn","corner","correct","cost","count","country","course","cover","crash","cross","cry","cup","cupboard","cut","dance","dangerous","dark","daughter","day","dead","decide","decrease","deep","deer","depend","desk","destroy","develop","die","different","difficult","dinner","direction","dirty","discover","dish","do","dog","door","double","down","draw","dream","dress","drink","drive","drop","dry","duck","dust","duty","each","ear","early","earn","earth","east","easy","eat","education","effect","egg","eight","either","electric","elephant","else","empty","end","enemy","enjoy","enough","enter","entrance","equal","escape","even","evening","event","ever","every","everybody","everyone","exact","examination","example","except","excited","exercise","expect","expensive","explain","extremely","eye","face","fact","fail","fall","false","family","famous","far","farm","fast","fat","father","fault","fear","feed","feel","female","fever","few","fight","fill","film","find","fine","finger","finish","fire","first","fish","fit","five","fix","flag","flat","float","floor","flour","flower","fly","fold","food","fool","foot","football","for","force","foreign","forest","forget","forgive","fork","form","four","fox","free","freedom","freeze","fresh","friend","friendly","from","front","fruit","full","fun","funny","furniture","further","future","game","garden","gate","general","gentleman","get","gift","give","glad","glass","go","goat","god","gold","good","goodbye","grandfather","grandmother","grass","grave","gray","great","green","ground","group","grow","gun","hair","half","hall","hammer","hand","happen","happy","hard","hat","hate","have","he","head","healthy","hear","heart","heaven","heavy","height","hello","help","hen","her","here","hers","hide","high","hill","him","his","hit","hobby","hold","hole","holiday","home","hope","horse","hospital","hot","hotel","hour","house","how","hundred","hungry","hurry","hurt","husband","I","ice","idea","if","important","in","increase","inside","into","introduce","invent","invite","iron","is","island","it","its","jelly","job","join","juice","jump","just","keep","key","kill","kind","king","kitchen","knee","knife","knock","know","ladder","lady","lamp","land","large","last","late","lately","laugh","lazy","lead","leaf","learn","leave","left","leg","lend","length","less","lesson","let","letter","library","lie","life","light","like","lion","lip","list","listen","little","live","lock","lonely","long","look","lose","lot","love","low","lower","luck","machine","main","make","male","man","many","map","mark","market","marry","matter","may","me","meal","mean","measure","meat","medicine","meet","member","mention","method","middle","milk","million","mind","minute","miss","mistake","mix","model","modern","moment","money","monkey","month","moon","more","morning","most","mother","mountain","mouth","move","much","music","must","my","name","narrow","nation","nature","near","nearly","neck","need","needle","neighbor","neither","net","never","new","news","newspaper","next","nice","night","nine","no","noble","noise","none","nor","north","nose","not","nothing","notice","now","number","obey","object","ocean","of","off","offer","office","often","oil","old","on","once","one","only","open","opposite","or","orange","order","other","our","out","outside","over","own","page","pain","paint","pair","pan","paper","parent","park","part","partner","party","pass","past","path","pay","peace","pen","pencil","people","pepper","per","perfect","period","person","petrol","photograph","piano","pick","picture","piece","pig","pin","pink","place","plane","plant","plastic","plate","play","please","pleased","plenty","pocket","point","poison","police","polite","pool","poor","popular","position","possible","potato","pour","power","present","press","pretty","prevent","price","prince","prison","private","prize","probably","problem","produce","promise","proper","protect","provide","public","pull","punish","pupil","push","put","queen","question","quick","quiet","quite","radio","rain","rainy","raise","reach","read","ready","real","really","receive","record","red","remember","remind","remove","rent","repair","repeat","reply","report","rest","restaurant","result","return","rice","rich","ride","right","ring","rise","road","rob","rock","room","round","rubber","rude","rule","ruler","run","rush","sad","safe","sail","salt","same","sand","save","say","school","science","scissors","search","seat","second","see","seem","sell","send","sentence","serve","seven","several","sex","shade","shadow","shake","shape","share","sharp","she","sheep","sheet","shelf","shine","ship","shirt","shoe","shoot","shop","short","should","shoulder","shout","show","sick","side","signal","silence","silly","silver","similar","simple","since","sing","single","sink","sister","sit","six","size","skill","skin","skirt","sky","sleep","slip","slow","small","smell","smile","smoke","snow","so","soap","sock","soft","some","someone","something","sometimes","son","soon","sorry","sound","soup","south","space","speak","special","speed","spell","spend","spoon","sport","spread","spring","square","stamp","stand","star","start","station","stay","steal","steam","step","still","stomach","stone","stop","store","storm","story","strange","street","strong","structure","student","study","stupid","subject","substance","successful","such","sudden","sugar","suitable","summer","sun","sunny","support","sure","surprise","sweet","swim","sword","table","take","talk","tall","taste","taxi","tea","teach","team","tear","telephone","television","tell","ten","tennis","terrible","test","than","that","the","their","then","there","therefore","these","thick","thin","thing","think","third","this","though","threat","three","tidy","tie","title","to","today","toe","together","tomorrow","tonight","too","tool","tooth","top","total","touch","town","train","tram","travel","tree","trouble","true","trust","try","turn","twice","two","type","ugly","uncle","under","understand","unit","until","up","use","useful","usual","usually","vegetable","very","village","visit","voice","wait","wake","walk","want","warm","was","wash","waste","watch","water","way","we","weak","wear","weather","wedding","week","weight","welcome","well","were","west","wet","what","wheel","when","where","which","while","white","who","why","wide","wife","wild","will","win","wind","window","wine","winter","wire","wise","wish","with","without","woman","wonder","word","work","world","worry","yard","yell","yesterday","yet","you","young","your","zero","zoo"];
$words_end = count($words) - 1;
function randomWord(){
    global $words;
    global $words_end;
    return $words[rand(0, $words_end)];
}

echo rand(0,999);
print_r($_POST);
if(isset($_POST['populate'])){
    if(isset($_POST['tables']) && $_POST['tables']){

        $tables_file = fopen("../create_tables.sql", "r");
        $create_tables = fread($tables_file,filesize("../create_tables.sql"));
        //echo $create_tables;
        $sql = explode(";", $create_tables);
        fclose($tables_file);

        //------Create tables-----------
        echo count($sql); echo "<br>";
        $db = new SQLite3('../data/database.db');
        for($i = 0; $i < count($sql)-1; $i++){
            $stmt = $db->prepare($sql[$i]);
            if($stmt){
                $result = $stmt->execute();
                if($result){
                    echo "<br> Successfully executed!";
                }}
            else{ $result = false; }

        }

    }

    if(isset($_POST['accounts']) && $_POST['accounts']){
        //-------Accounts-----------
        $total_accounts = 100;
        for($i = 0; $i < $total_accounts; $i++){
            $params = array(
                'username' => randomWord() . randomWord() . randomWord() . rand(100,999),
                'password' => "password",
                'email' => randomWord() . randomWord() . randomWord() . "@email.com",
                'account_type' => 2
            );
            $new_account = new Account($params);
            $result = $new_account->createAccount();
        }
    }

    if(isset($_POST['blogs']) && $_POST['blogs']){
        //-------------blog posts---------------
        $film_names = ["There will be Blood", "Avatar 2", "Amadeus", "All of us strangers"];
        $subjects = array(
            array(  //Naruto
                "title" => (function(){ return "Naruto Shippuden episode " . rand(1,500) . " review"; }),
                "content" => "It has been two and a half years since Naruto Uzumaki left Konohagakure, the Hidden Leaf Village, for intense training following events which fueled his desire to be stronger. Now Akatsuki, the mysterious organization of elite rogue ninja, is closing in on their grand plan which may threaten the safety of the entire shinobi world.<br>Although Naruto is older and sinister events loom on the horizon, he has changed little in personality—still rambunctious and childish—though he is now far more confident and possesses an even greater determination to protect his friends and home. Come whatever may, Naruto will carry on with the fight for what is important to him, even at the expense of his own body, in the continuation of the saga about the boy who wishes to become Hokage.",
                "tags" => ["naruto", "sasuke", "review", "anime"],
                "love_comment" => ["Super insightful! Thanks.", "One of the best breakdowns I've seen.", "Wow<br>Amazing."],
                "hate_comment" => ["Delete your account. Delete your account. Delete your account. Delete your account.  You should: Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. Delete your account. "],
            ),
            array(  //film reviews
                "title" => (function(){ global $film_names; return $film_names[rand(0,3)] . " review!"; }),
                "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi rutrum fermentum risus sit amet placerat. Nam id enim interdum, rutrum elit non, dignissim mauris. Fusce venenatis mi vitae purus condimentum facilisis. Integer orci ex, tincidunt ac tincidunt a, aliquam ac augue. Etiam id ex congue, volutpat ligula sit amet, pellentesque mi. Proin vel magna et augue consectetur aliquet. Donec massa urna, feugiat a mauris tempor, dignissim sodales dolor. In vitae risus euismod, feugiat magna eu, lobortis metus. Suspendisse faucibus ac ante id congue.<br><br>Suspendisse vitae purus leo. Donec mattis massa pellentesque vehicula pretium. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas vitae egestas nunc. Curabitur blandit vulputate nisl, viverra accumsan arcu dictum nec. Sed dolor nulla, aliquet quis sapien in, eleifend maximus nisi.<br><br>Sed id hendrerit purus, ac semper leo. In imperdiet laoreet risus eu mattis. Proin sollicitudin enim in ex condimentum laoreet. Sed consectetur id justo vitae imperdiet. Aliquam ligula nibh, faucibus sit amet faucibus vel, euismod non diam. Praesent ut tempus tortor. Duis posuere metus quis libero fringilla, at scelerisque est aliquet. Sed consequat pharetra malesuada.<br><br>Nullam elementum odio dui, id volutpat mi ullamcorper quis. Maecenas nec mi vel lorem auctor convallis. Nam non nisl id ex auctor aliquet. Donec auctor tortor sed mattis pellentesque. Vestibulum enim ligula, tincidunt a ipsum ut, convallis luctus felis. Sed eget ex vitae tellus tempor dapibus in nec ipsum. Morbi placerat vehicula massa, vel mattis massa lobortis porta. Sed leo nisi, ultrices quis libero varius, interdum efficitur nibh. Duis et eros nisi. Cras laoreet, libero sit amet elementum posuere, lacus est viverra libero, id consequat justo ex vel justo. Donec ipsum urna, bibendum blandit venenatis nec, rutrum in orci. Fusce dictum a magna in euismod.<br><br>Curabitur et dictum sapien. Suspendisse sit amet dolor id metus auctor tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum semper risus ligula, vel varius metus bibendum eu. Mauris feugiat turpis nibh, pellentesque imperdiet odio vulputate eu. Praesent finibus finibus odio eget luctus. Sed ultrices arcu id pretium convallis. Nulla sodales augue diam, vel placerat leo porta sit amet. Sed dignissim rhoncus magna, eget pulvinar velit efficitur vel. Ut sed condimentum erat. ",
                "tags" => ["review", "film", "cinema"],
                "love_comment" => ["ipsum dolor sit amet, consectetur adipiscing elit. Morbi rutrum fermentum risus sit [positive]", "pellentesque mi. Proin vel magna et augue consectetur aliquet. Donec massa urna, feugiat a mauris tempor,", "lorem ispum, lorem pisum, lorem ipsum, lorem ispum, lorem ipsum, orem ispum, lorem ipsum, lorem ipsum,"],
                "hate_comment" => ["Stop speaking gibberish you [ableist SLUR]"],
            ),
            array(  //top ten films
                "title" => (function(){ return "My top 10 films"; }),
                "content" => "1) Avatar 2<br><br>2) Avatar 2<br><br>3) Avatar 2<br><br>4) Avatar 2<br><br>5) Avatar 2<br><br>6) Avatar 2<br><br>7) Avatar 2<br><br>8) Avatar 2<br><br>9) Avatar 2<br><br>10) Avatar 2<br><br>",
                "tags" => ["film", "cinema", "topten"],
                "love_comment" => ["My top 10 list is the same except upside down.", "Amazing.", "phenomial", "fenomonial"],
                "hate_comment" => ["Stupid."],
            ),
            array(  //top ten anime films
                "title" => (function(){ return "My top 10 anime films"; }),
                "content" => "1) Avatar (The last airbender) 2<br><br>2) Avata(The last airbender)r 2<br><br>3) (The last airbender)Avatar 2<br><br>4) Avatar 2<br><br>5) Avatar 2       (The last airbender)<br><br>6) Avatar 2 (The last airbender)<br><br>7) Avatar 2(The last airbender)<br><br>8) Avatar (The last airbender)2<br><br>9) Avatar(The last airbender) 2<br><br>10) Ava(The last airbender)tar 2<br><br>",
                "tags" => ["film", "cinema", "topten", "anime"],
                "love_comment" => ["Avatar the last airbender is a television show   isn't that funny?","about","above","across","act","active","activity","add","afraid","after","again","age"],
                "hate_comment" => ["Terrible list, never make another one"],
            )
        );
        
        $total_blogs = 100;
        $report_types = ["Harassment","Hate speech","Encouraging violence"];

        for($i = 0; $i < $total_blogs; $i++){
            $subject_data = $subjects[rand(0,3)];
            $params = array(
                'account_id' => rand(1,17), //one of the first 17 accounts, so that they have denser feeds
                'visibility' => 2,
                'title' => $subject_data["title"](),
                'contents' => $subject_data["content"]
            );
            //print_r($params);
            $new_blogpost = new BlogPost($params);
            $result = $new_blogpost->createBlog();

            //---------blog tags-----------------
            $params = array(
                'blog_id'=>$new_blogpost->blog_id,
                'tag_type'=>"content",
                'tag_name'=>""
            );
            for($j = 0; $j < count($subject_data['tags']); $j++){
                $params['tag_name'] = $subject_data['tags'][$j];
                $new_blog_tag = new BlogTag($params);
                $result = $new_blog_tag->createBlogTag();
            }
            
            $love = true;
            if(rand(0,1) == 0){
                $love = false;
            }
            //------------blog reports-------------------------
            if(!$love){
                $params = array(
                    'blog_id' => $new_blogpost->blog_id,
                    'contents' => $new_blogpost->contents,
                    'report_type' => $report_types[rand(0,2)],
                );
                $new_blog_report = new BlogReport($params);
                $result = $new_blog_report->createBlogReport();
            }

            //----------comments------------------
            $comment_text = "";
            for($j = 0; $j < rand(0,4); $j++){
                $love = true;
                if(rand(0,2) == 0){ //hate
                    $love = false;
                    $comment_text = $subject_data["hate_comment"][rand(0,count($subject_data["hate_comment"])-1)];
                }
                else{   //love
                    $comment_text = $subject_data["love_comment"][rand(0,count($subject_data["love_comment"])-1)];
                }
                $params = array(
                    'account_id' => rand(1,100),
                    'blog_id' => $new_blogpost->blog_id,
                    'contents' => $comment_text,
                );

                $new_comment = new Comment($params);
                $result = $new_comment->createComment();
                //--------------comment reports--------------------
                if(!$love){
                    $params = array(
                        'comment_id' => $new_comment->comment_id,
                        'contents' => $new_comment->contents,
                        'report_type' => $report_types[rand(0,2)],
                    );

                    $new_comment_report = new CommentReport($params);
                    $result = $new_comment_report->createCommentReport();
                }
            }
        }
    }
}
?>
</html>
