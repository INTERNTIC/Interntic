((o) => {
    "use strict";
  
    class Dashboard {
      constructor() {
        this.$body = o("body");
        this.charts = [];
      }
  
      initCharts(data_array) {
        const { colors } = window.Apex;
        const revenueChartColors = o("#revenue-chart").data("colors");
        // const averageSalesColors = o("#average-sales").data("colors");
  
        const r = {
          chart: {
            height: 203,
            type: "donut",
          },
          legend: {
            show: false,
          },
          stroke: {
            colors: ["transparent"],
          },
          series: [data_array[0].value,data_array[1].value, data_array[2].value, data_array[3].value],
          labels: [data_array[0].name, data_array[1].name, data_array[2].name, data_array[3].name],
          colors: revenueChartColors ? revenueChartColors.split(",") : colors,
          responsive: [
            {
              breakpoint: 480,
              options: {
                chart: {
                  width: 200,
                },
                legend: {
                  position: "bottom",
                },
              },
            },
          ],
        };
  
        new ApexCharts(document.querySelector("#average-sales"), r).render();
      }
  
      init(data_array) {
        o("#dash-daterange").daterangepicker({
          singleDatePicker: true,
        });
        if (data_array.length!=0) {
          console.log(data_array);
          this.initCharts(data_array);
        }
      }
    }
  
    const dashboard = new Dashboard();
    o.Dashboard = dashboard;
    o.Dashboard.Constructor = Dashboard;
  })(window.jQuery);
  
  ((t) => {
    "use strict";
    t(document).ready((e) => {
    //   t.Dashboard.init();
    });
  })(window.jQuery);
  