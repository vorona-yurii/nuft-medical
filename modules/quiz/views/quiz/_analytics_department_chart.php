<?php

/* @var $quiz \app\modules\quiz\models\Quiz */
/* @var $data array */

?>

<!-- Styles -->
<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
    am4core.ready(function () {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create("chartdiv", am4charts.XYChart3D);

        // Add data
        // chart.data = [{
        //     "name": "USA",
        //     "value": 32.5,
        // }, {
        //     "name": "UK",
        //     "value": 11.7,
        // }, {
        //     "name": "Canada",
        //     "value": 33.8,
        // }, {
        //     "name": "Japan",
        //     "value": 55.6,
        // }, {
        //     "name": "France",
        //     "value": 99.4,
        // }];
        chart.data = <?= $data ?>;

        // Title
        var title = chart.titles.push(new am4core.Label());
        title.text = "Опитування №<?= $quiz->quiz_id ?>. Аналітика по підрозділам";
        title.fontSize = 25;
        title.marginBottom = 15;

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "name";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Відсоток вірних відповідей";
        valueAxis.renderer.labels.template.adapter.add("text", function (text) {
            return text + "%";
        });

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries3D());
        series.dataFields.valueY = "value";
        series.dataFields.categoryX = "name";
        series.clustered = false;
        series.columns.template.tooltipText = "Вірних відповідей відділу {categoryX}: [bold]{valueY}%[/]";
        series.columns.template.fillOpacity = 0.9;

    }); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>