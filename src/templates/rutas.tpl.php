<?php
ini_set("display_errors", 1);
require __DIR__ . "/../funciones/funciones.class.php";

$obj{{Class}} = new {{ClassName}}();

$app->get("/get", function ($request, $response, $args) use ($obj{{Class}}) {
    $resultado = $obj{{Class}}->get();
    $response->getBody()->write(json_encode($resultado));
    return $response->withHeader("Content-Type", "application/json");
});

$app->get("/getById/{id}", function ($request, $response, $args) use ($obj{{Class}}) {
    $id = $args["id"];
    $response->getBody()->write(json_encode($obj{{Class}}->getById($id)));
    return $response->withHeader("Content-Type", "application/json");
});

$app->post("/post", function ($request, $response, $args) use ($obj{{Class}}) {
    $data = $request->getParsedBody()["data"];
    $response->getBody()->write(json_encode($obj{{Class}}->post($data)));
    return $response->withHeader("Content-Type", "application/json");
});