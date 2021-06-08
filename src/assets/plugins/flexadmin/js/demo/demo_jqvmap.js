import '../../vendors/jqvmap/jquery.vmap.min.js';
import '../../vendors/jqvmap/maps/jquery.vmap.world.js';
import '../../vendors/jqvmap/maps/jquery.vmap.usa.js';
import '../../vendors/jqvmap/maps/continents/jquery.vmap.asia.js';
import '../../vendors/jqvmap/maps/jquery.vmap.usa.districts.js';

class DemoVectorMap {
  constructor() {}

  init() {
    this.worldMap();
    this.usaMap();
    this.usaDistricts();
    this.asiaMap();
  }

  worldMap() {
    var activeColor = window.colors.blue;
    var selectedCountries = ['us', 'ru'];
    var colors = { 'us': activeColor, 'ru': activeColor, 'au': activeColor, };
    $('#world_map').vectorMap({
      map: 'world_en',
      backgroundColor: null,
      borderColor: '#818181',
      borderOpacity: 0.25,
      borderWidth: 1,
      color: window.colors.gray,
      enableZoom: true,
      hoverColor: '#ccc',
      hoverOpacity: null,
      normalizeFunction: 'linear',
      scaleColors: ['#b6d6ff', '#005ace'],
      selectedColor: '#c9dfaf',
      selectedRegions: null,
      showTooltip: true,
      colors: colors,
      hoverOpacity: 0.7
    });
  }

  usaMap() {
    $('#usa-map').vectorMap({
      map: 'usa_en',
      backgroundColor: null,
      color: window.colors.gray,
      enableZoom: true,
      showTooltip: true,
      selectedColor: null,
      hoverColor: null,
      colors: {
        mo: '#2980b9',
        fl: '#27ae60',
        or: '#8e44ad'
      },
      onRegionClick: function(event, code, region) {
        event.preventDefault();
      }
    });
  }

  usaDistricts() {
    $('#usa-districts-map').vectorMap({
      map: 'usa_districts_en',
      backgroundColor: null,
      borderColor: '#000',
      enableZoom: true,
      showTooltip: true,
      selectedColor: null,
      color: '#5b5b5b',
      hoverColor: '#ccc',
      onRegionClick: function(event, code, region) {
        event.preventDefault();
      }
    });
  }

  asiaMap() {
    $('#asia-map').vectorMap({
      map: 'asia_en',
      backgroundColor: null,
      enableZoom: true,
      color: '#5b5b5b',
      hoverColor: '#999999',
      enableZoom: false,
    });
  }
}

new DemoVectorMap().init();