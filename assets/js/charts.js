const lastSevenDays = [...new Array(7)]
  .map((i, idx) => [
    moment().startOf("day").subtract(idx, "days").format("dddd"),
    moment().startOf("day").subtract(idx, "days").format("ll"),
  ])
  .reverse()

Chart.register(ChartDataLabels)

function updateChartColors() {
  var charts = [
    activeDriverChart,
    activeDriverChartMin,
    waitTimeChart,
    waitTimeMinChart,
    dailyShipmentsChart,
    timeUtilizationChart,
    shipmentsChart,
    facilityChart,
    accoiShipmentTargetChart,
    acontShipmentTargetChart,
    lineageShipmentTargetChart,
    comparisonChart,
    tripTimeEstimatesChart,
    timeCompletingInstructionsChart,
    timeWaitingForInstructionsChart,
  ]

  charts.forEach((chart) => {
    if (chart == null) return

    chart.options.color =
      localStorage.getItem("theme") === "light" ? "#7F7F7F" : "#CCCCCC"
    chart.options.borderColor =
      localStorage.getItem("theme") === "light" ? "#eee" : "#252526"

    if (chart.options.scales.x) {
      chart.options.scales.x.title.color =
        localStorage.getItem("theme") === "light" ? "#7F7F7F" : "#CCCCCC"
      chart.options.scales.x.grid.color =
        localStorage.getItem("theme") === "light"
          ? "rgba(138, 136, 136, 0.2)"
          : "rgba(255, 255, 255, 0.2)"
      chart.options.scales.x.ticks.color =
        localStorage.getItem("theme") === "light" ? "#7F7F7F" : "#CCCCCC"
      chart.options.scales.x.border.color =
        localStorage.getItem("theme") === "light"
          ? "rgba(138, 136, 136, 0.1)"
          : "rgba(255, 255, 255, 0.2)"
    }

    if (chart.options.scales.x2) {
      chart.options.scales.x2.title.color =
        localStorage.getItem("theme") === "light" ? "#7F7F7F" : "#CCCCCC"
      chart.options.scales.x2.grid.color =
        localStorage.getItem("theme") === "light"
          ? "rgba(138, 136, 136, 0.2)"
          : "rgba(255, 255, 255, 0.2)"
      chart.options.scales.x2.ticks.color =
        localStorage.getItem("theme") === "light" ? "#7F7F7F" : "#CCCCCC"
      chart.options.scales.x2.border.color =
        localStorage.getItem("theme") === "light"
          ? "rgba(138, 136, 136, 0.1)"
          : "rgba(255, 255, 255, 0.2)"
    }

    if (chart.options.scales.y) {
      chart.options.scales.y.grid.color =
        localStorage.getItem("theme") === "light"
          ? "rgba(138, 136, 136, 0.2)"
          : "rgba(255, 255, 255, 0.2)"
      chart.options.scales.y.ticks.color =
        localStorage.getItem("theme") === "light" ? "#7F7F7F" : "#CCCCCC"
      chart.options.scales.y.border.color =
        localStorage.getItem("theme") === "light"
          ? "rgba(138, 136, 136, 0.1)"
          : "rgba(255, 255, 255, 0.2)"
    }

    if (
      chart.data.datasets[0].datalabels &&
      chart != facilityChart &&
      chart != shipmentsChart &&
      chart != timeUtilizationChart &&
      chart != tripTimeEstimatesChart
    ) {
      var datasets = chart.data.datasets
      datasets.forEach((data) => {
        data.datalabels.color =
          localStorage.getItem("theme") === "light" ? "#7F7F7F" : "#CCCCCC"
      })
    }

    if (
      chart == accoiShipmentTargetChart ||
      chart == acontShipmentTargetChart ||
      chart == lineageShipmentTargetChart
    ) {
      chart.data.datasets[1].borderColor =
        localStorage.getItem("theme") === "light"
          ? "rgba(127, 127, 127, 0.2)"
          : "rgba(211, 211, 211, 0.3)"
      chart.data.datasets[1].backgroundColor =
        localStorage.getItem("theme") === "light"
          ? "rgba(127, 127, 127, 0.2)"
          : "rgba(211, 211, 211, 0.3)"
    }
    chart.update()
  })
}

function randomIntFromInterval(min, max) {
  // min and max included
  return Math.floor(Math.random() * (max - min + 1) + min)
}

function generate(max, thecount) {
  var r = []
  var currsum = 0
  for (var i = 0; i < thecount - 1; i++) {
    r[i] = randombetween(10, max - (thecount - i - 1) - currsum - 5)
    currsum += r[i]
  }
  r[thecount - 1] = max - currsum < 0 ? 0 : max - currsum
  return r
}

function randombetween(min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min)
}

function updateChartData(startDate, endDate) {
  let dayDifference = endDate.diff(startDate, "days") + 1

  let data = [...new Array(dayDifference)].map((i, idx) =>
    randomIntFromInterval(15, 120)
  )

  let data1 = [...new Array(dayDifference)].map((i, idx) =>
    randomIntFromInterval(15, 200)
  )

  let data2 = [...new Array(dayDifference)].map((i, idx) =>
    randomIntFromInterval(15, 60)
  )

  let data3 = [...new Array(dayDifference)].map((i, idx) =>
    randomIntFromInterval(15, 60)
  )

  let data4 = [...new Array(dayDifference)].map((i, idx) =>
    randomIntFromInterval(25, 60)
  )

  let data5 = [...new Array(dayDifference)].map((i, idx) =>
    randomIntFromInterval(10, 30)
  )

  let data6 = [...new Array(dayDifference)].map((i, idx) =>
    randomIntFromInterval(10, 30)
  )

  let data7 = [...new Array(dayDifference)].map((i, idx) =>
    randomIntFromInterval(5, 15)
  )

  let labels = [],
    labelsShort = []
  for (var m = moment(startDate); m.isBefore(endDate); m.add(1, "days")) {
    labels.push([m.format("dddd"), m.format("l")])
    labelsShort.push(m.format("l"))
  }

  var charts = [
    Chart.getChart("waitTimeChart"),
    Chart.getChart("timeWaitingForInstructionsChart"),
    Chart.getChart("timeCompletingInstructionsChart"),
  ]

  charts.forEach(function (chart) {
    chart.data.labels = dayDifference > 7 ? labelsShort : labels
    chart.data.datasets[0].data = data
    chart.data.datasets[0].datalabels.display = dayDifference <= 7
    chart.data.datasets[1].data = data1
    chart.data.datasets[1].datalabels.display = dayDifference <= 7
    chart.data.datasets[2].data = data2
    chart.data.datasets[2].datalabels.display = dayDifference <= 7
    chart.data.datasets[3].data = data3
    chart.data.datasets[3].datalabels.display = dayDifference <= 7
    chart.options.scales.x.stacked = false
    chart.options.scales.y.ticks.suggestedMax = 50
    chart.options.scales.y.ticks.suggestedMin = 1
    chart.options.scales.y.ticks.beginAtZero = true
    chart.options.scales.y.ticks.max = 100
    chart.options.scales.y.ticks.autoSkip = true
    chart.options.scales.y.ticks.lineHeight = 2
    waitTimeChart.update()
  })

  var facilityUtilizationChart = Chart.getChart("facilityChart")
  facilityUtilizationChart.data.datasets[0].data = generate(100, 3)
  facilityUtilizationChart.update()

  var timeUtilizationChart = Chart.getChart("timeUtilizationChart")
  timeUtilizationChart.data.datasets[0].data = generate(100, 5)
  timeUtilizationChart.update()

  const ctx = document.getElementById("shipmentsChart").getContext("2d")
  if (dayDifference > 3) {
    // switching to line (hide facilities)
    shipmentsChart.destroy()
    shipmentsChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: dayDifference > 7 ? labelsShort : labels,
        datasets: [
          {
            label: "Total Shipments",
            backgroundColor: "#3D68BB",
            borderColor: "#3D68BB",
            data: data4,
            datalabels: {
              align: "end",
              anchor: "end",
            },
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 20,
            right: 20,
            top: 0,
            bottom: 0,
          },
        },
        scales: {
          y: {
            grace: 5,
          },
        },
        plugins: {
          legend: {
            //display: false,
          },
          datalabels: {
            backgroundColor: function (context) {
              return context.dataset.backgroundColor
            },
            borderRadius: 3,
            color: "white",
            font: {
              weight: "bold",
            },
            formatter: Math.round,
          },
        },
        elements: {
          line: {
            fill: false,
            tension: 0.4,
          },
        },
      },
    })
    shipmentsChart.update()
  } else {
    shipmentsChart.destroy()
    shipmentsChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: dayDifference > 7 ? labelsShort : labels,
        datasets: [
          {
            label: "Total Shipments",
            backgroundColor: "#3D68BB",
            borderColor: "#3D68BB",
            data: data4,
            datalabels: {
              align: "end",
              anchor: "end",
            },
          },
        ],
      },
      options: {
        minBarLength: 5,
        barPercentage: 0.6,
        categoryPercentage: 0.8,
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 20,
            right: 20,
            top: 0,
            bottom: 0,
          },
        },
        scales: {
          y: {
            grace: 5,
          },
        },
        plugins: {
          legend: {
            //display: false,
          },
          datalabels: {
            display: dayDifference <= 7,
            backgroundColor: function (context) {
              return context.dataset.backgroundColor
            },
            borderRadius: 3,
            color: "white",
            font: {
              weight: "bold",
            },
            formatter: Math.round,
          },
        },
        elements: {
          line: {
            fill: false,
            tension: 0.4,
          },
        },
      },
    })
    shipmentsChart.update()
    // switching to bar (show facilities)
  }
  updateChartColors()
}

function updateComparisonChartData(
  startDateMain,
  endDateMain,
  startDateComparison,
  endDateComparison,
  facility
) {
  let dayDifference = endDateMain.diff(startDateMain, "days") + 1
  let dayDifference2 = endDateComparison.diff(startDateComparison, "days") + 1

  let data = [...new Array(dayDifference)].map((i, idx) =>
    randomIntFromInterval(10, 65)
  )

  let data1 = [...new Array(dayDifference2)].map((i, idx) =>
    randomIntFromInterval(10, 55)
  )

  let labels = [],
    labelsShort = []
  let labels2 = [],
    labelsShort2 = []
  for (
    var m = moment(startDateMain);
    m.isBefore(endDateMain);
    m.add(1, "days")
  ) {
    labels.push([m.format("dddd"), m.format("l")])
    labelsShort.push(m.format("l"))
  }
  for (
    var m = moment(startDateComparison);
    m.isBefore(endDateComparison);
    m.add(1, "days")
  ) {
    labels2.push([m.format("dddd"), m.format("l")])
    labelsShort2.push(m.format("l"))
  }

  var val = labels.length > labels2.length ? labels.length : labels2.length

  var realLabels = []
  for (var i = 0; i < val; i++) {
    realLabels.push(labels[i] + "#" + labels2[i])
  }

  var realLabelsShort = []
  for (var i = 0; i < val; i++) {
    realLabelsShort.push(labelsShort[i] + "#" + labelsShort2[i])
  }

  const title = (tooltipItems) => {
    return $("#compareMetricButton").html()
  }

  const footer = (tooltipItems) => {
    if (tooltipItems.length <= 1) return "No Change"
    let main = tooltipItems[0].parsed.y
    let comparison = tooltipItems[1].parsed.y

    return "Change: " + (((comparison - main) / main) * 100).toFixed(2) + "%"
  }

  const ctx = document.getElementById("comparisonChart").getContext("2d")
  if (dayDifference > 7 || dayDifference2 > 7) {
    comparisonChart.destroy()
    comparisonChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: realLabelsShort,
        datasets: [
          {
            label:
              startDateMain.format("ll") + " - " + endDateMain.format("ll"),
            borderColor: "#3D68BB",
            backgroundColor: "#3D68BB",
            borderRadius: 5,
            data: data,
            datalabels: {
              display: false,
            },
          },
          {
            label:
              startDateComparison.format("ll") +
              " - " +
              endDateComparison.format("ll"),
            borderColor: "#E69322",
            backgroundColor: "#E69322",
            borderRadius: 5,
            data: data1,
            datalabels: {
              display: false,
            },
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 10,
            top: 0,
            bottom: 0,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        plugins: {
          tooltip: {
            callbacks: {
              intersect: true,
              title: title,
              label: function (context) {
                let label =
                  context.label.split("#")[context.datasetIndex == 0 ? 0 : 1] ||
                  ""
                return label + ": " + context.parsed.y
              },
              footer: footer,
            },
          },
          datalabels: {
            align: "end",
            anchor: "end",
            font: {
              size: "10px",
            },
          },
        },
        scales: {
          x: {
            id: "main",
            title: {
              display: true,
              text: "Main",
            },
            ticks: {
              callback: function (value, index, ticks) {
                var label = this.getLabelForValue(value).split("#")[0]
                return label.replace("undefined", "No Data")
              },
            },
          },
          x2: {
            id: "compare",
            title: {
              display: true,
              text: "Comparison",
            },
            ticks: {
              callback: function (value, index, ticks) {
                var label = this.getLabelForValue(value).split("#")[1]
                return label.replace("undefined", "No Data")
              },
            },
          },
          y: {
            grace: 2,
          },
        },
      },
      elements: {
        line: {
          fill: false,
          tension: 0.4,
        },
      },
    })
    comparisonChart.update()
  } else {
    comparisonChart.destroy()
    comparisonChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: realLabels,
        datasets: [
          {
            label:
              startDateMain.format("ll") + " - " + endDateMain.format("ll"),
            borderColor: "#3D68BB",
            backgroundColor: "#3D68BB",
            borderRadius: 5,
            data: data,
            datalabels: {
              align: "end",
              anchor: "end",
            },
          },
          {
            label:
              startDateComparison.format("ll") +
              " - " +
              endDateComparison.format("ll"),
            borderColor: "#E69322",
            backgroundColor: "#E69322",
            borderRadius: 5,
            data: data1,
            datalabels: {
              align: "end",
              anchor: "end",
            },
          },
        ],
      },
      options: {
        minBarLength: 5,
        barPercentage: 0.7,
        categoryPercentage: 0.9,
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 10,
            top: 0,
            bottom: 0,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        plugins: {
          tooltip: {
            intersect: true,
            callbacks: {
              intersect: true,
              title: title,
              label: function (context) {
                let label =
                  context.label.split("#")[context.datasetIndex == 0 ? 0 : 1] ||
                  ""
                return label.replace(",", ", ") + ": " + context.parsed.y
              },
              footer: footer,
            },
          },
          datalabels: {
            align: "end",
            anchor: "end",
            font: {
              size: "10px",
            },
          },
        },
        scales: {
          x: {
            id: "main",
            title: {
              display: true,
              text: "Main",
            },
            ticks: {
              callback: function (value, index, ticks) {
                var label = this.getLabelForValue(value).split("#")[0]
                return label.replace("undefined", "No Data").replace(",", ", ")
              },
            },
          },
          x2: {
            id: "compare",
            title: {
              display: true,
              text: "Comparison",
            },
            ticks: {
              callback: function (value, index, ticks) {
                var label = this.getLabelForValue(value).split("#")[1]
                return label.replace("undefined", "No Data").replace(",", ", ")
              },
            },
          },
          y: {
            beginAtZero: true,
            grace: 2,
          },
        },
      },
      elements: {
        line: {
          fill: false,
          tension: 0.4,
        },
      },
    })
    comparisonChart.update()
  }
}

function toggleShipmentsChart() {
  const dataLength = shipmentsChart.data.datasets[0].data.length

  let data = [...new Array(dataLength)].map((i, idx) =>
    randomIntFromInterval(20, 60)
  )

  let data1 = [...new Array(dataLength)].map((i, idx) =>
    randomIntFromInterval(10, 25)
  )

  let data2 = [...new Array(dataLength)].map((i, idx) =>
    randomIntFromInterval(10, 30)
  )

  let data3 = [...new Array(dataLength)].map((i, idx) =>
    randomIntFromInterval(5, 15)
  )

  let labels = shipmentsChart.data.labels
  const ctx = document.getElementById("shipmentsChart").getContext("2d")
  if (shipmentsChart.config.type === "bar") {
    // switching to line (hide facilities)
    shipmentsChart.destroy()
    shipmentsChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Total Shipments",
            backgroundColor: "#3D68BB",
            borderColor: "#3D68BB",
            data: data,
            datalabels: {
              align: "end",
              anchor: "end",
            },
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 20,
            right: 20,
            top: 0,
            bottom: 0,
          },
        },
        scales: {
          y: {
            grace: 5,
          },
        },
        plugins: {
          legend: {
            //display: false,
          },
          datalabels: {
            backgroundColor: function (context) {
              return context.dataset.backgroundColor
            },
            borderRadius: 3,
            color: "white",
            font: {
              weight: "bold",
            },
            formatter: Math.round,
          },
        },
        elements: {
          line: {
            fill: false,
            tension: 0.4,
          },
        },
      },
    })
    shipmentsChart.update()
  } else {
    shipmentsChart.destroy()
    shipmentsChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Americold COI",
            backgroundColor: "#E69322",
            borderColor: "#E69322",
            borderRadius: 5,
            data: data1,
            datalabels: {
              align: "end",
              anchor: "end",
            },
          },
          {
            label: "Americold Ontario",
            backgroundColor: "#218B94",
            borderColor: "#218B94",
            borderRadius: 5,
            data: data2,
            datalabels: {
              align: "end",
              anchor: "end",
            },
          },
          {
            label: "Lineage Riverside",
            backgroundColor: "#399D37",
            borderColor: "#399D37",
            borderRadius: 5,
            data: data3,
            datalabels: {
              align: "end",
              anchor: "end",
            },
          },
        ],
      },
      options: {
        minBarLength: 5,
        barPercentage: 0.6,
        categoryPercentage: 0.8,
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 20,
            right: 20,
            top: 0,
            bottom: 0,
          },
        },
        scales: {
          y: {
            grace: 5,
          },
        },
        plugins: {
          legend: {
            //display: false,
          },
          datalabels: {
            display: dataLength <= 7,
            backgroundColor: function (context) {
              return context.dataset.backgroundColor
            },
            borderRadius: 3,
            color: "white",
            font: {
              weight: "bold",
            },
            formatter: Math.round,
          },
        },
        elements: {
          line: {
            fill: false,
            tension: 0.4,
          },
        },
      },
    })
    shipmentsChart.update()
    // switching to bar (show facilities)
  }
}

var comparisonChart = null
if (document.getElementById("comparisonChart")) {
  const ctx = document.querySelector("#comparisonChart").getContext("2d")
  comparisonChart = comparisonChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [],
      datasets: [
        {
          label: "Main",
          borderColor: "#3D68BB",
          backgroundColor: "#3D68BB",
          borderRadius: 5,
          data: [],
        },
        {
          label: "Comparison",
          borderColor: "#E69322",
          backgroundColor: "#E69322",
          borderRadius: 5,
          data: [],
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 10,
          top: 0,
          bottom: 0,
        },
      },
    },
    /*plugins: [{
      id: 'customValue',
      afterDraw: (chart, args, opts) => {
        const {
          ctx,
          data: {
            datasets
          },
          _metasets
        } = chart;
  
        datasets[1].data.forEach((dp, i) => {
          let increasePercent = dp * 100 / datasets[0].data[i] >= 100 ? Math.round((dp * 100 / datasets[0].data[i] - 100) * 100) / 100 : Math.round((100 - dp * 100 / datasets[0].data[i]) * 100) / 100 * -1;
          let barValue = `${increasePercent}%`;
          const lineHeight = ctx.measureText('M').width;
          const offset = opts.offset || 0;
          const dash = opts.dash || [];
  
          ctx.textAlign = 'center';
          ctx.fillStyle = 'white';
          ctx.strokeStyle = 'white';
  
          ctx.fillText(barValue, _metasets[1].data[i].x + 50, (_metasets[1].data[i].y - lineHeight * 1.5), _metasets[1].data[i].width);
  
          if (_metasets[0].data[i].y >= _metasets[1].data[i].y) {
            ctx.beginPath();
            ctx.setLineDash(dash);
  
            ctx.moveTo(_metasets[0].data[i].x, _metasets[0].data[i].y - offset - lineHeight * 2.5);
            ctx.lineTo(_metasets[0].data[i].x, _metasets[1].data[i].y - offset);
            ctx.lineTo(_metasets[1].data[i].x, _metasets[1].data[i].y - offset);
            ctx.stroke();
          } else {
            ctx.beginPath();
            ctx.setLineDash(dash);
  
            ctx.moveTo(_metasets[0].data[i].x + 10, _metasets[0].data[i].y - offset - lineHeight * 1.6);
            ctx.lineTo(_metasets[1].data[i].x, _metasets[0].data[i].y - offset - lineHeight * 1.6);
            ctx.lineTo(_metasets[1].data[i].x, _metasets[1].data[i].y - offset - lineHeight * (increasePercent > 5 ? 2.5 : 1));
            ctx.stroke();
          }
        });
      }
    }]*/
  })
}

var waitTimeChart = null
if (document.getElementById("waitTimeChart")) {
  const ctx = document.getElementById("waitTimeChart").getContext("2d")
  waitTimeChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday",
      ],
      labels: lastSevenDays,
      datasets: [
        {
          label: "Facility",
          backgroundColor: "#3D68BB",
          borderRadius: 5,
          data: [45, 11, 112, 26, 34, 160, 22],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
        {
          label: "Americold COI",
          backgroundColor: "#E69322",
          borderRadius: 5,
          data: [36, 91, 364, 221, 25, 25, 185],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
        {
          label: "Americold Ontario",
          backgroundColor: "#218B94",
          borderRadius: 5,
          data: [15, 25, 23, 36, 31, 18, 45],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
        {
          label: "Lineage Riverside",
          backgroundColor: "#399D37",
          borderRadius: 5,
          data: [10, 20, 30, 40, 50, 60, 70],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
      ],
    },
    options: {
      minBarLength: 5,
      barPercentage: 0.7,
      categoryPercentage: 0.9,
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 10,
          top: 0,
          bottom: 0,
        },
      },
      scales: {
        y: {
          grace: 5,
        },
      },
      plugins: {
        tooltip: {
          intersect: true,
          mode: "nearest",
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || ""

              if (label) {
                label += ": "
              }
              if (context.parsed.y !== null) {
                label += convertMinsToHrsMins(context.parsed.y, false)
              }
              return label + " (average)"
            },
          },
        },
        datalabels: {
          align: "end",
          anchor: "end",
          font: {
            size: "10px",
          },
          formatter: function (value, context) {
            return convertMinsToHrsMins(value, true)
          },
        },
      },
    },
  })
}

var timeCompletingInstructionsChart = null
if (document.getElementById("timeCompletingInstructionsChart")) {
  const ctx = document
    .getElementById("timeCompletingInstructionsChart")
    .getContext("2d")
  timeCompletingInstructionsChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday",
      ],
      labels: lastSevenDays,
      datasets: [
        {
          label: "Facility",
          backgroundColor: "#3D68BB",
          borderRadius: 5,
          data: [15, 21, 19, 25, 8, 10, 13],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
        {
          label: "Americold COI",
          backgroundColor: "#E69322",
          borderRadius: 5,
          data: [21, 13, 19, 10, 15, 23, 35],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
        {
          label: "Americold Ontario",
          backgroundColor: "#218B94",
          borderRadius: 5,
          data: [21, 18, 30, 15, 20, 14, 10],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
        {
          label: "Lineage Riverside",
          backgroundColor: "#399D37",
          borderRadius: 5,
          data: [10, 15, 8, 13, 11, 15, 17],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
      ],
    },
    options: {
      minBarLength: 5,
      barPercentage: 0.7,
      categoryPercentage: 0.9,
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 10,
          top: 0,
          bottom: 0,
        },
      },
      scales: {
        y: {
          grace: 5,
        },
      },
      plugins: {
        tooltip: {
          intersect: true,
          mode: "nearest",
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || ""

              if (label) {
                label += ": "
              }
              if (context.parsed.y !== null) {
                label += convertMinsToHrsMins(context.parsed.y, false)
              }
              return label + " (average)"
            },
          },
        },
        datalabels: {
          align: "end",
          anchor: "end",
          font: {
            size: "10px",
          },
          formatter: function (value, context) {
            return convertMinsToHrsMins(value, true)
          },
        },
      },
    },
  })
}

var timeWaitingForInstructionsChart = null
if (document.getElementById("timeWaitingForInstructionsChart")) {
  const ctx = document
    .getElementById("timeWaitingForInstructionsChart")
    .getContext("2d")
  timeWaitingForInstructionsChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday",
      ],
      labels: lastSevenDays,
      datasets: [
        {
          label: "Facility",
          backgroundColor: "#3D68BB",
          borderRadius: 5,
          data: [29, 18, 33, 77, 34, 110, 31],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
        {
          label: "Americold COI",
          backgroundColor: "#E69322",
          borderRadius: 5,
          data: [26, 51, 264, 125, 31, 44, 100],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
        {
          label: "Americold Ontario",
          backgroundColor: "#218B94",
          borderRadius: 5,
          data: [21, 6, 13, 22, 4, 13, 21],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
        {
          label: "Lineage Riverside",
          backgroundColor: "#399D37",
          borderRadius: 5,
          data: [5, 11, 18, 8, 33, 9, 15],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
      ],
    },
    options: {
      minBarLength: 5,
      barPercentage: 0.7,
      categoryPercentage: 0.9,
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 10,
          top: 0,
          bottom: 0,
        },
      },
      scales: {
        y: {
          grace: 5,
        },
      },
      plugins: {
        tooltip: {
          intersect: true,
          mode: "nearest",
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || ""

              if (label) {
                label += ": "
              }
              if (context.parsed.y !== null) {
                label += convertMinsToHrsMins(context.parsed.y, false)
              }
              return label + " (average)"
            },
          },
        },
        datalabels: {
          align: "end",
          anchor: "end",
          font: {
            size: "10px",
          },
          formatter: function (value, context) {
            return convertMinsToHrsMins(value, true)
          },
        },
      },
    },
  })
}

var facilityChart = null
if (document.getElementById("facilityChart")) {
  const ctx = document.getElementById("facilityChart").getContext("2d")
  facilityChart = new Chart(ctx, {
    type: "pie",
    data: {
      labels: ["Americold COI", "Americold Ontario", "Lineage Riverside"],
      datasets: [
        {
          label: "Shipments sent to facility",
          backgroundColor: ["#E69322", "#218B94", "#399D37"],
          borderRadius: 1,
          data: [39, 51, 12],
          datalabels: {
            color: "white",
            align: "center",
            anchor: "center",
          },
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 0,
          bottom: 0,
        },
      },
      plugins: {
        datalabels: {
          align: "end",
          anchor: "end",
          formatter: function (value, context) {
            return value + "%"
          },
          color: "white",
          font: {
            weight: "bold",
          },
        },
        tooltip: {
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || ""

              if (label) {
                label += ": "
              }
              if (context.parsed !== null) {
                label += context.parsed
                return label + " (" + context.parsed + "%)"
              }
              return label
            },
          },
        },
      },
    },
  })
}

var shipmentsChart = null
if (document.getElementById("shipmentsChart")) {
  const ctx = document.getElementById("shipmentsChart").getContext("2d")
  shipmentsChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
      labels: lastSevenDays,
      datasets: [
        {
          label: "Total Shipments",
          backgroundColor: "#3D68BB",
          borderColor: "#3D68BB",
          data: [
            1401, 1334, 1177, 1039, 1300, 1332, 1200, 1044, 1092, 1193, 1053,
            1442,
          ],
          data: [56, 49, 52, 19, 22, 41, 49],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 20,
          right: 20,
          top: 0,
          bottom: 0,
        },
      },
      scales: {
        y: {
          grace: 5,
        },
      },
      plugins: {
        legend: {
          //display: false,
        },
        datalabels: {
          backgroundColor: function (context) {
            return context.dataset.backgroundColor
          },
          borderRadius: 3,
          color: "white",
          font: {
            weight: "bold",
          },
          formatter: Math.round,
        },
      },
      elements: {
        line: {
          fill: false,
          tension: 0.4,
        },
      },
    },
  })
}

var timeUtilizationChart = null
if (document.getElementById("timeUtilizationChart")) {
  const ctx = document.getElementById("timeUtilizationChart").getContext("2d")
  timeUtilizationChart = new Chart(ctx, {
    type: "pie",
    //plugins: [pluginShowPercentage],
    data: {
      labels: [
        "Driving (Shipments)",
        "Driving (Backhauls)",
        "Waiting @ Warehouse",
        "Waiting @ Danone",
        "Yard Moves",
        "Other",
      ],
      //labels: ["Driving", "Backhauls", "Waiting @ Warehouse", "Waiting @ Danone", "Yard Moves", "Breaks", "Fueling", "Shop", "Breakdowns", "Broken Trailers"],
      datasets: [
        {
          label: "Percentage of time",
          backgroundColor: [
            "rgb(76, 184, 104)",
            "rgb(238, 53, 67)",
            "rgb(63, 183, 195)",
            "rgb(232, 162, 68)",
            "rgb(171, 65, 209)",
            "#7f7f7f",
          ],
          data: [40, 10, 25, 10, 5, 10],
          datalabels: {
            color: "#fff",
            align: "center",
            anchor: "center",
          },
        },
      ],
    },
    options: {
      cutout: 70,
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 20,
          bottom: 20,
        },
      },
      plugins: {
        legend: {
          position: "left",
        },
        datalabels: {
          color: "white",
          font: {
            weight: "bold",
          },
          formatter: function (value, context) {
            return value > 0 ? value + "%" : ""
          },
        },
        tooltip: {
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || ""

              if (label) {
                label += ": "
              }
              if (context.parsed !== null) {
                label += context.parsed
              }
              return label + "%"
            },
          },
        },
      },
    },
  })
}

var waitTimeMinChart = null
if (document.getElementById("waitTimeMinChart")) {
  const ctx = document.getElementById("waitTimeMinChart").getContext("2d")
  waitTimeMinChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Danone", "Americold COI", "Americold ONT", "Lineage Riverside"],
      datasets: [
        {
          label: "Average wait time",
          backgroundColor: ["#3D68BB", "#E69322", "#218B94", "#399D37"],
          borderRadius: 3,
          data: [30, 180, 35, 20],
          datalabels: {
            align: "end",
            anchor: "end",
            formatter: function (value, context) {
              return convertMinsToHrsMins(value, true)
            },
          },
        },
      ],
    },
    options: {
      //barThickness: 8,
      barPercentage: 0.5,
      categoryPercentage: 1.0,
      indexAxis: "y",
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 0,
          right: 26,
          top: 0,
          bottom: 0,
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          mode: "nearest",
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || ""

              if (label) {
                label += ": "
              }
              if (context.parsed.x !== null) {
                label += convertMinsToHrsMins(context.parsed.x, false)
              }
              return label
            },
          },
        },
      },
      scales: {
        x: {
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            display: false,
          },
          ticks: {
            display: false,
          },
        },
        y: {
          grace: 5,
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            display: false,
          },
          ticks: {},
        },
      },
    },
  })
}

function randomIntFromInterval(min, max) {
  // min and max included
  return Math.floor(Math.random() * (max - min + 1) + min)
}

function getTargetData(facility) {
  $.ajax({
    type: "POST",
    dataType: "json",
    data: "action=get",
    url: "src/config.php",
  }).done(function (data) {
    setData(facility, data)
  })
}

function setData(facility, data) {
  var target
  var result = []
  if (facility === "accoi") {
    target = data["targets"]["accoi"]
  } else if (facility === "acont") {
    target = data["targets"]["acont"]
  } else if (facility === "lineage") {
    target = data["targets"]["lineage"]
  } else {
    console.log('Unhandled facility: "' + facility + '"')
  }

  var sent = facility === "accoi" ? 26 : facility === "acont" ? 22 : 4

  result = [...new Array(8)].map((i, idx) => target)

  let deduction1 = randomIntFromInterval(
    facility === "lineage" ? 0 : 2,
    target / 5
  )
  let deduction2 =
    deduction1 +
    randomIntFromInterval(facility === "lineage" ? 0 : 2, target / 5)
  let deduction3 =
    deduction2 +
    randomIntFromInterval(facility === "lineage" ? 0 : 2, target / 5)
  let deduction4 =
    deduction3 +
    randomIntFromInterval(facility === "lineage" ? 1 : 2, target / 5)
  let deduction5 =
    deduction4 +
    randomIntFromInterval(facility === "lineage" ? 1 : 2, target / 5)
  let deduction6 =
    deduction5 +
    randomIntFromInterval(facility === "lineage" ? 1 : 2, target / 5)
  if (deduction2 > target) deduction2 = target
  if (deduction3 > target) deduction3 = target
  if (deduction4 > target) deduction4 = target
  if (deduction5 > target) deduction5 = target
  if (deduction6 > target) deduction6 = target

  $("#" + facility + "-sent").html(deduction6)
  $("#" + facility + "-remaining").html(target - deduction6)

  var chart = Chart.getChart(facility + "ShipmentTargetChart")
  chart.options.scales.x.ticks.min = 100
  chart.data.datasets[0].data = [
    deduction1,
    deduction2,
    deduction3,
    deduction4,
    deduction5,
    deduction6,
  ]
  chart.data.datasets[1].data = result
  chart.update()
}

var accoiShipmentTargetChart = null
var acontShipmentTargetChart = null
var lineageShipmentTargetChart = null
if (
  document.getElementById("accoiShipmentTargetChart") &&
  document.getElementById("acontShipmentTargetChart") &&
  document.getElementById("lineageShipmentTargetChart")
) {
  const labels = [
    "12 AM",
    "3 AM",
    "6 AM",
    "9 AM",
    "12 PM",
    "3 PM",
    "6 PM",
    "9 PM",
  ]
  const accoiData = {
    labels: labels,
    datasets: [
      {
        fill: true,
        type: "line",
        label: "Shipped",
        backgroundColor: "rgba(230, 147, 34, 0.4)",
        borderColor: "#E69322",
        data: [],
        datalabels: {
          align: "end",
          anchor: "end",
        },
      },
      {
        type: "line",
        label: "Target",
        data: getTargetData("accoi"),
        datalabels: {
          display: false,
        },
        backgroundColor: "rgba(211, 211, 211, 0.4)",
        borderColor: "rgba(211, 211, 211, 0.6)",
      },
    ],
  }
  const acontData = {
    labels: labels,
    datasets: [
      {
        fill: true,
        type: "line",
        label: "Shipped",
        backgroundColor: "rgba(33, 139, 148, 0.4)",
        borderColor: "#218B94",
        data: [],
        datalabels: {
          align: "end",
          anchor: "end",
        },
      },
      {
        type: "line",
        label: "Target",
        data: getTargetData("acont"),
        datalabels: {
          display: false,
        },
        backgroundColor: "rgba(211, 211, 211, 0.4)",
        borderColor: "rgba(211, 211, 211, 0.6)",
      },
    ],
  }
  const lineageData = {
    labels: labels,
    datasets: [
      {
        fill: true,
        type: "line",
        label: "Shipped",
        backgroundColor: "rgba(57, 157, 55, 0.4)",
        borderColor: "#399D37",
        data: [],
        datalabels: {
          align: "end",
          anchor: "end",
        },
      },
      {
        type: "line",
        label: "Target",
        data: getTargetData("lineage"),
        datalabels: {
          display: false,
        },
        backgroundColor: "rgba(211, 211, 211, 0.4)",
        borderColor: "rgba(211, 211, 211, 0.6)",
      },
    ],
  }
  const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0,
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        grace: 3,
      },
    },
    plugins: {
      legend: {
        display: false,
      },
      title: {
        display: false,
      },
      datalabels: {
        borderRadius: 3,
        font: {
          weight: "bold",
        },
        formatter: Math.round,
      },
    },
    elements: {
      line: {
        fill: false,
        tension: 0.1,
      },
    },
  }

  const ctxIndustry = document
    .getElementById("accoiShipmentTargetChart")
    .getContext("2d")
  const ctxOntario = document
    .getElementById("acontShipmentTargetChart")
    .getContext("2d")
  const ctxLineage = document
    .getElementById("lineageShipmentTargetChart")
    .getContext("2d")
  accoiShipmentTargetChart = new Chart(ctxIndustry, {
    type: "scatter",
    data: accoiData,
    options: chartOptions,
  })
  acontShipmentTargetChart = new Chart(ctxOntario, {
    type: "scatter",
    data: acontData,
    options: chartOptions,
  })
  lineageShipmentTargetChart = new Chart(ctxLineage, {
    type: "scatter",
    data: lineageData,
    options: chartOptions,
  })
}

var tripTimeEstimatesChart = null
if (document.getElementById("tripTimeEstimatesChart")) {
  const ctx = document.getElementById("tripTimeEstimatesChart").getContext("2d")
  tripTimeEstimatesChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["AC COI", "AC ONT", "Lineage"],
      datasets: [
        {
          backgroundColor: ["#E69322", "#218B94", "#399D37"],
          borderRadius: 3,
          data: [15 * 2 + 15 * 2 + 5, 35 * 2 + 10 * 2 + 5, 45 * 2 + 10 * 2 + 5],
          datalabels: {
            align: "start",
            anchor: "end",
          },
        },
      ],
    },
    options: {
      //barThickness: 8,
      indexAxis: "y",
      minBarLength: 10,
      barPercentage: 0.5,
      categoryPercentage: 1.0,
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 0,
          bottom: 0,
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          intersect: true,
          mode: "nearest",
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || ""

              if (label) {
                label += ": "
              }
              if (context.parsed.y !== null) {
                label += convertMinsToHrsMins(context.parsed.x, false)
              }
              return label + " (average)"
            },
          },
        },
        datalabels: {
          align: "end",
          anchor: "end",
          align: "center",
          color: "white",
          borderRadius: 3,
          font: {
            weight: "bold",
          },
          formatter: function (value, context) {
            var currentTime = moment()
            var returnTime = currentTime.add(value, "minutes")
            return (
              convertMinsToHrsMins(value, true) +
              " (Return ~" +
              returnTime.format("LT") +
              ")"
            )
          },
        },
      },
      scales: {
        x: {
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            display: false,
          },
          ticks: {
            display: false,
          },
        },
        y: {
          grace: 10,
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            display: false,
          },
          ticks: {
            display: true,
          },
        },
      },
    },
  })
}

var dailyShipmentsChart = null
if (document.getElementById("dailyShipmentsChart")) {
  const ctx = document.getElementById("dailyShipmentsChart").getContext("2d")
  dailyShipmentsChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday",
      ],
      datasets: [
        {
          backgroundColor: [
            "rgba(211, 211, 211, 0.4)",
            "rgba(211, 211, 211, 0.4)",
            "#43B581",
            "rgba(211, 211, 211, 0.4)",
            "rgba(211, 211, 211, 0.4)",
            "rgba(211, 211, 211, 0.4)",
            "rgba(211, 211, 211, 0.4)",
          ],
          borderRadius: 3,
          data: [51, 44, 36, 0, 0, 0, 0],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
      ],
    },
    options: {
      //barThickness: 8,
      minBarLength: 10,
      barPercentage: 0.4,
      categoryPercentage: 1.0,
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 15,
          bottom: 0,
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          intersect: false,
          mode: "nearest",
        },
      },
      scales: {
        x: {
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            display: false,
          },
          ticks: {
            display: false,
          },
        },
        y: {
          grace: 2,
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            display: false,
          },
          ticks: {
            display: false,
          },
        },
      },
    },
  })
}

var activeDriverChartMin = null
if (document.getElementById("activeDriverChartMin")) {
  const ctx = document.getElementById("activeDriverChartMin").getContext("2d")
  activeDriverChartMin = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Danone", "AC COI", "AC ONT", "Lineage"],
      datasets: [
        {
          label: "Drivers at Facility",
          backgroundColor: ["#3D68BB", "#E99A3C", "#218B94", "#5FAD40"],
          borderRadius: 4,
          data: [4, 1, 2, 1],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
      ],
    },
    options: {
      //barThickness: 8,
      minBarLength: 5,
      barPercentage: 0.3,
      categoryPercentage: 1.0,
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 25,
          bottom: 0,
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          intersect: false,
          mode: "nearest",
        },
      },
      scales: {
        x: {
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            // display: false,
          },
          ticks: {
            // display: false,
          },
        },
        y: {
          grace: 2,
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            display: false,
          },
          ticks: {
            display: false,
          },
        },
      },
    },
  })
}

var activeDriverChart = null
if (document.getElementById("activeDriverChart")) {
  const ctx = document.getElementById("activeDriverChart").getContext("2d")
  activeDriverChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [
        "Facility",
        "Americold",
        "Lineage",
        "US Cold Storage",
        "Lunch Break",
      ],
      datasets: [
        {
          label: "Drivers at Facility",
          backgroundColor: [
            "#3D68BB",
            "#E99A3C",
            "#218B94",
            "#5FAD40",
            "#F94449",
          ],
          borderRadius: 4,
          data: [4, 1, 2, 1, 1],
          datalabels: {
            align: "end",
            anchor: "end",
          },
        },
      ],
    },
    options: {
      //barThickness: 8,
      minBarLength: 5,
      barPercentage: 0.3,
      categoryPercentage: 1.0,
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 25,
          bottom: 0,
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          intersect: false,
          mode: "nearest",
        },
      },
      scales: {
        x: {
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            // display: false,
          },
          ticks: {
            // display: false,
          },
        },
        y: {
          grid: {
            display: false,
          },
          border: {
            display: false,
          },
          title: {
            display: false,
          },
          ticks: {
            display: false,
          },
        },
      },
    },
  })
}

function convertMinsToHrsMins(mins, short) {
  let h = Math.floor(mins / 60)
  let m = mins % 60
  return short
    ? (h > 0 ? h + "h " : "") + (h > 0 ? m + "m" : m + "m")
    : (h > 0 ? h + " hour" + (h > 1 ? "s " : " ") : "") + "" + m + " minutes"
}
