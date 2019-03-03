<?php
require_once('../access.php');
require_once('../connector.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include(ROOT_DIR."/imports.php"); ?>
    
</head>
<body>
    <?php include(ROOT_DIR."/header.php"); ?>
    <section class="hero is-medium is-primary is-bold">
        <div class="hero-body">
            <div class="container">
            <h1 class="title">
                Palauig Monitoring and Information System for Senior Citizen
            </h1>
            <h2 class="subtitle">
                Organizational Structure
            </h2>
            </div>
        </div>
    </section>
    <section style="transform: translateY(-100px);">
        <div class="columns">
            <div class="column is-1"></div>
            <div class="column is-10">
                <div class="box">
                <div id="gochart" class="is-fullwidth" style="height:600px;"></div>
                
                </div>
            </div>
            <div class="column is-1"></div>
        </div>
    </section>

    <script>
        var chart = go.GraphObject.make;
        var myDiagram =
        chart(go.Diagram, "gochart",
            {
                "undoManager.isEnabled": true, // enable Ctrl-Z to undo and Ctrl-Y to redo
                layout: chart(go.TreeLayout, // specify a Diagram.layout that arranges trees
                            { angle: 90, layerSpacing: 35 }),
                initialContentAlignment: go.Spot.Center,
            });
        
        
        // the template we defined earlier
        myDiagram.nodeTemplate =
        chart(go.Node, "Horizontal",
            { background: "#0097a7" },
            
        
          // a table to contain the different parts of the node
          chart(go.Panel, "Table",
            { margin: 10,maxSize: new go.Size(500, 500) },
            // the two TextBlocks in column 0 both stretch in width
            // but align on the left side
            chart(go.RowColumnDefinition,
              {
                isRow :true,
                column: 1,
                stretch: go.GraphObject.Horizontal,
                alignment: go.Spot.Center,
              }),
            

            // chart(go.Picture,
            // { column:0,rowSpan:2, margin: 10, width: 70, height: 70, background: "gray" },
            // new go.Binding("source")),

            chart(go.TextBlock,
            { row:0,column:1,columnSpan: 2, margin: new go.Margin(10, 10, 0, 0), stroke: "#fafafa", font: "bold 13px sans-serif", alignment: go.Spot.BottomLeft  },
            new go.Binding("text", "name")),

            chart(go.TextBlock,
            { row:1,column:1,columnSpan: 2, margin: new go.Margin(10, 10, 0, 0), stroke:'#fafafa', font: "13px sans-serif",alignment: go.Spot.TopLeft },
            new go.Binding("text","title")),
          ),
        );

        var model = chart(go.TreeModel);
        model.nodeDataArray =
        [
        { key: "1",              name: "Billy M. Aceron",       title:   "Municipal Mayor" },
        { key: "2", parent: "1", name: "Fred M. Sevilla",       title:   "Committee on Elderly" },
        { key: "3", parent: "1", name: "Leonardo A. Apuyan",    title:   "OSCA Chairman" },
        { key: "4", parent: "1", name: "Ester P. Aceron",       title:   "MSWDO" },
        { key: "5", parent: "3", name: "Prospero N. Barcena",   title:   "Fed. President" },
        { key: "6", parent: "5", name: "Yolanda F. Cabiles",    title:   "Fed. Vice President" },
        { key: "7", parent: "5", name: "Lorenza A. Cecilio",    title:   "Fed. Secretary" },
        { key: "8", parent: "5", name: "Jacqueline M. Bradley", title:   "Fed. Treasurer" },
        { key: "9", parent: "5", name: "Rita Q. Abujen",        title:   "Fed. Auditor" },
        { key: "10",             name: "Business Managers"},
        { key: "11", parent: "10", name: "Azucena C. Ramirez" },
        { key: "12", parent: "10", name: "Cristina C. Destura" },
        { key: "13", parent: "10", name: "Victoria G. Cabiles" },
        { key: "14",             name: "Press Information Officers", title: "(P.I.O.)"},
        { key: "15", parent: "14", name: "Melchor S. Rosal" },
        { key: "16", parent: "14", name: "Leopoldo P. Ponseca" },
        { key: "17",             name: "Board of Directors" },
        { key: "18", parent: "17", name: "Novenacion C. Vallespin" },
        { key: "19", parent: "17", name: "Lucila R. Dizon" },
        { key: "20", parent: "17", name: "Emilita E. Cadondon" },
        { key: "21", parent: "17", name: "Peregrin A. Ambuyoc" },
        { key: "22", parent: "17", name: "Cresencia Galang" },
        // { key: "6", parent: "2", name: "Munkustrap", source: "cat6.png" }
        ];
        myDiagram.model = model;
    </script>
</body>
</html>