import * as d3 from 'd3/dist/d3.min';
import * as britecharts from 'britecharts/dist/bundled/britecharts.min';

import { BAR_CHART_DATA, LINE_CHART_DATA, BRUSH_CHART_DATA, DONUT_CHART_DATA, STACKED_BAR_CHART } from '../chart/britechart_data.js';

class DemoBritecharts {
  constructor() {}

  init() {
    this.barChart('#bar-container', false);
    this.barChart('#horizontal-bar-container', true);
    this.lineChart('#line-chart-container');
    this.brushChart('#brush-chart-container');
    this.donutChart('#donut-chart-container');
    this.stackedBarChart('#stacked-bar-chart-container');
  }

  barChart(element, isHorizontal) {
    let chartTooltip = new britecharts.miniTooltip();
    let _barChart = new britecharts.bar();
    let barContainer = d3.select(element),
      containerWidth = barContainer.node() ?
      barContainer.node().getBoundingClientRect().width :
      false,
      containerHeight = barContainer.node() ?
      barContainer.node().getBoundingClientRect().height :
      false,
      tooltipContainer = void 0;

    let margin = {
      top: 10,
      left: 40,
      bottom: 30,
      right: 10,
    };

    _barChart
      .isAnimated(true)
      .isHorizontal(isHorizontal)
      .width(containerWidth)
      .height(containerHeight)
      .margin(margin)
      .betweenBarsPadding(0.5)
      .colorSchema([window.colors.blue, window.colors.red])
      .on('customMouseOver', chartTooltip.show)
      .on('customMouseMove', chartTooltip.update)
      .on('customMouseOut', chartTooltip.hide);

    barContainer.datum(BAR_CHART_DATA).call(_barChart);
    tooltipContainer = d3.select(element + ' .metadata-group');
    tooltipContainer.datum([]).call(chartTooltip);
  }

  lineChart(element) {
    let chart = new britecharts.line();
    let chartTooltip = new britecharts.tooltip();
    let lineContainer = d3.select(element);
    let containerWidth = lineContainer.node() ?
      lineContainer.node().getBoundingClientRect().width :
      false;
    let tooltipContainer = 0;
    let margin = {
      top: 30,
      left: 40,
      bottom: 80,
      right: 10,
    };
    chart
      .isAnimated(true)
      .aspectRatio(0.7)
      .tooltipThreshold(100)
      .margin(margin)
      .grid('horizontal')
      .width(containerWidth)
      .dateLabel('date')
      .valueLabel('value')
      .on('customMouseOver', chartTooltip.show)
      .on('customMouseMove', chartTooltip.update)
      .on('customMouseOut', chartTooltip.hide);

    chartTooltip.title('Demo Data');
    lineContainer.datum(LINE_CHART_DATA).call(chart);
    tooltipContainer = d3.select(
      element + ' .metadata-group .hover-marker'
    );
    tooltipContainer.datum([]).call(chartTooltip);
  }

  brushChart(element) {
    let brushContainer = d3.select(element);
    let chart = britecharts.brush(),
      containerWidth = brushContainer.node() ?
      brushContainer.node().getBoundingClientRect().width :
      false;

    chart
      .height(320)
      .width(containerWidth)
      .gradient(window.colors.blue)

    brushContainer.datum(BRUSH_CHART_DATA).call(chart);

    chart.dateRange(['7/15/2015', '7/25/2015'])
  }

  donutChart(element) {
    let donutChart = britecharts.donut(),
      legendChart = britecharts.legend(),
      legendContainer = void 0;

    legendChart
      .width(250)
      .height(200)
      .colorSchema([
        window.colors.blue,
        window.colors.red,
        window.colors.green,
        window.colors.yellow,
        window.colors.gray,
        window.colors.purple,
      ])
      .numberFormat('s');

    donutChart
      .isAnimated(true)
      .height(300)
      .highlightSliceById(3)
      .colorSchema([
        window.colors.blue,
        window.colors.red,
        window.colors.green,
        window.colors.yellow,
        window.colors.gray,
        window.colors.purple,
      ])
      .hasFixedHighlightedSlice(true)
      .internalRadius(80);

    d3.select(element)
      .datum(DONUT_CHART_DATA)
      .call(donutChart);
    legendContainer = d3.select('.legend-chart-container');
    legendContainer.datum(DONUT_CHART_DATA).call(legendChart);
  }

  stackedBarChart(element) {
    let stackedBar = britecharts.stackedBar(),
      legendChart = britecharts.legend(),
      legendContainer = void 0;

    let barContainer = d3.select(element),
      containerWidth = barContainer.node() ?
      barContainer.node().getBoundingClientRect().width :
      false;
    stackedBar
      .tooltipThreshold(600)
      .height(350)
      .width(containerWidth)
      .grid('horizontal')
      .isAnimated(true)
      .stackLabel('stack')
      .nameLabel('date')
      .valueLabel('views')
      .betweenBarsPadding(0.3);
    barContainer.datum(STACKED_BAR_CHART).call(stackedBar);

  }

}

window.demoBritecharts = new DemoBritecharts();
window.demoBritecharts.init();