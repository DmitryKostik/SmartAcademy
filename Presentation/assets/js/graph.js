google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Сервис', 'Преподаватели', 'Студенты'],
    ['Изменение \nрасписания', 94, 72],
    ['Материалы \nлекций и\n семинаров', 52, 73],
    ['Управление \n мобильными\n устройствами', 65, 57],
    ['Электронная \nбиблиотека', 60, 48],
    ['Он-лайн \nестирование', 45, 44],
    ['Персональная \nинформация', 22, 34],
    ['Общение \nучащихся и \nпреподавателей', 31, 34],
    ['Культурная и \nспортивная\n жизнь', 19, 28],
    ['Портфолио', 12, 13]
  ]);

  var options = {
    chart: {
      title: 'Актуальность разработки Мобильной Академии',
      subtitle: 'Востребованость мобильных сервисов в 9 федеральных университетах России'
    },
    legend: {position: 'none', textStyle: {fontSize: 10}},
    hAxis: {format: 'percent',textStyle: {fontSize: 10}, title: ""},
    is3D: true
  };

  var chart = new google.charts.Bar(document.getElementById('barchart_material'));

  chart.draw(data, google.charts.Bar.convertOptions(options));
}

$(window).resize(function(){
  drawChart();
});
