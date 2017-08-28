<?php

$wdb->select("{$wconfig['db']['tablepre']}article_category",
    array("cid", "pid", "name", "status", "displayorder"),
    array("status"=>'1')
);

$wdb->get("{$wconfig['db']['tablepre']}role","roleid","rolename",array("roleid"=>$roleid));


$wdb->insert("{$wconfig['db']['tablepre']}article",array(
    "cid"=>$cid,
    "status"=>$status,

));

$wdb->update("{$wconfig['db']['tablepre']}role",array("permission"=>$permission_str),array("roleid"=>$roleid));


delete("{$wconfig['db']['tablepre']}article_category", array("cid"=>$cid));

$wdb->delete("account", [
	"AND" => [
		"type" => "business",
		"age[<]" => 18
	]
]);