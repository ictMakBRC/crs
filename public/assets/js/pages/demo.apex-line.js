var colors=["#ffbc00"],dataColors=$("#line-chart").data("colors");dataColors&&(colors=dataColors.split(","));var options={chart:{height:380,type:"line",zoom:{enabled:!1}},dataLabels:{enabled:!1},colors:colors,stroke:{width:[4],curve:"straight"},series:[{name:"Desktops",data:[30,41,35,51,49,62,69,91,126]}],title:{text:"Product Trends by Month",align:"center"},grid:{row:{colors:["transparent","transparent"],opacity:.2},borderColor:"#f1f3fa"},labels:series.monthDataSeries1.dates,xaxis:{categories:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep"]},responsive:[{breakpoint:600,options:{chart:{toolbar:{show:!1}},legend:{show:!1}}}]},chart=new ApexCharts(document.querySelector("#line-chart"),options);chart.render();colors=["#727cf5","#0acf97","#fa5c7c","#ffbc00"];(dataColors=$("#line-chart-datalabel").data("colors"))&&(colors=dataColors.split(","));options={chart:{height:380,type:"line",zoom:{enabled:!1},toolbar:{show:!1}},colors:colors,dataLabels:{enabled:!0},stroke:{width:[3,3],curve:"smooth"},series:[{name:"High - 2018",data:[28,29,33,36,32,32,33]},{name:"Low - 2018",data:[12,11,14,18,17,13,13]}],title:{text:"Average High & Low Temperature",align:"left"},grid:{row:{colors:["transparent","transparent"],opacity:.2},borderColor:"#f1f3fa"},markers:{style:"inverted",size:6},xaxis:{categories:["Jan","Feb","Mar","Apr","May","Jun","Jul"],title:{text:"Month"}},yaxis:{title:{text:"Temperature"},min:5,max:40},legend:{position:"top",horizontalAlign:"right",floating:!0,offsetY:-25,offsetX:-5},responsive:[{breakpoint:600,options:{chart:{toolbar:{show:!1}},legend:{show:!1}}}]};(chart=new ApexCharts(document.querySelector("#line-chart-datalabel"),options)).render();for(var ts2=14844186e5,dates=[],spikes=[5,-5,3,-3,8,-8],i=0;i<120;i++){var innerArr=[ts2+=864e5,dataSeries[1][i].value];dates.push(innerArr)}colors=["#fa5c7c"];(dataColors=$("#line-chart-zoomable").data("colors"))&&(colors=dataColors.split(","));options={chart:{type:"area",stacked:!1,height:380,zoom:{enabled:!0}},plotOptions:{line:{curve:"smooth"}},dataLabels:{enabled:!1},stroke:{width:[3]},series:[{name:"XYZ MOTORS",data:dates}],markers:{size:0,style:"full"},colors:colors,title:{text:"Stock Price Movement",align:"left"},grid:{row:{colors:["transparent","transparent"],opacity:.2},borderColor:"#f1f3fa"},fill:{gradient:{enabled:!0,shadeIntensity:1,inverseColors:!1,opacityFrom:.5,opacityTo:.1,stops:[0,70,80,100]}},yaxis:{min:2e7,max:25e7,labels:{formatter:function(e){return(e/1e6).toFixed(0)}},title:{text:"Price"}},xaxis:{type:"datetime"},tooltip:{shared:!1,y:{formatter:function(e){return(e/1e6).toFixed(0)}}},responsive:[{breakpoint:600,options:{chart:{toolbar:{show:!1}},legend:{show:!1}}}]};(chart=new ApexCharts(document.querySelector("#line-chart-zoomable"),options)).render();colors=["#39afd1"];(dataColors=$("#line-chart-annotations").data("colors"))&&(colors=dataColors.split(","));options={annotations:{yaxis:[{y:8200,borderColor:"#0acf97",label:{borderColor:"#0acf97",style:{color:"#fff",background:"#0acf97"},text:"Support"}}],xaxis:[{x:new Date("23 Nov 2017").getTime(),borderColor:"#775DD0",label:{borderColor:"#775DD0",style:{color:"#fff",background:"#775DD0"},text:"Anno Test"}},{x:new Date("03 Dec 2017").getTime(),borderColor:"#ffbc00",label:{borderColor:"#ffbc00",style:{color:"#fff",background:"#ffbc00"},orientation:"horizontal",text:"New Beginning"}}],points:[{x:new Date("27 Nov 2017").getTime(),y:8506.9,marker:{size:8,fillColor:"#fff",strokeColor:"#fa5c7c",radius:2},label:{borderColor:"#fa5c7c",offsetY:0,style:{color:"#fff",background:"#fa5c7c"},text:"Point Annotation"}}]},chart:{height:380,type:"line",id:"areachart-2"},colors:colors,dataLabels:{enabled:!1},stroke:{width:[3],curve:"straight"},series:[{data:series.monthDataSeries1.prices}],title:{text:"Line with Annotations",align:"left"},labels:series.monthDataSeries1.dates,xaxis:{type:"datetime"},grid:{row:{colors:["transparent","transparent"],opacity:.2},borderColor:"#f1f3fa"},responsive:[{breakpoint:600,options:{chart:{toolbar:{show:!1}},legend:{show:!1}}}]};(chart=new ApexCharts(document.querySelector("#line-chart-annotations"),options)).render();colors=["#727cf5"];(dataColors=$("#line-chart-syncing").data("colors"))&&(colors=dataColors.split(","));var optionsline2={chart:{type:"line",height:160,id:"fb",group:"social"},colors:colors,stroke:{width:[3],curve:"straight"},toolbar:{tools:{selection:!1}},fill:{opacity:1},tooltip:{followCursor:!1,theme:"dark",x:{show:!1},marker:{show:!1},y:{title:{formatter:function(){return""}}}},series:[{data:generateDayWiseTimeSeries(new Date("11 Feb 2017").getTime(),20,{min:10,max:30})}],xaxis:{type:"datetime"},grid:{row:{colors:["transparent","transparent"],opacity:.2},borderColor:"#f1f3fa"}},chartline2=new ApexCharts(document.querySelector("#line-chart-syncing"),optionsline2);chartline2.render();colors=["#6c757d"];(dataColors=$("#line-chart-syncing2").data("colors"))&&(colors=dataColors.split(","));options={chart:{height:200,type:"line",id:"yt",group:"social"},colors:colors,dataLabels:{enabled:!1},toolbar:{tools:{selection:!1}},tooltip:{followCursor:!1,theme:"dark",x:{show:!1},marker:{show:!1},y:{title:{formatter:function(){return""}}}},stroke:{width:[3],curve:"smooth"},series:[{data:generateDayWiseTimeSeries(new Date("11 Feb 2017").getTime(),20,{min:10,max:60})}],fill:{gradient:{enabled:!0,opacityFrom:.6,opacityTo:.8}},legend:{position:"top",horizontalAlign:"left"},xaxis:{type:"datetime"},grid:{row:{colors:["transparent","transparent"],opacity:.2},borderColor:"#f1f3fa"}};function generateDayWiseTimeSeries(e,t,a){for(var o=0,r=[];o<t;){var s=e,n=Math.floor(Math.random()*(a.max-a.min+1))+a.min;r.push([s,n]),e+=864e5,o++}return r}(chart=new ApexCharts(document.querySelector("#line-chart-syncing2"),options)).render();options={chart:{height:374,type:"line",shadow:{enabled:!1,color:"#bbb",top:3,left:2,blur:3,opacity:1}},stroke:{width:5,curve:"smooth"},series:[{name:"Likes",data:[4,3,10,9,29,19,22,9,12,7,19,5,13,9,17,2,7,5]}],xaxis:{type:"datetime",categories:["1/11/2000","2/11/2000","3/11/2000","4/11/2000","5/11/2000","6/11/2000","7/11/2000","8/11/2000","9/11/2000","10/11/2000","11/11/2000","12/11/2000","1/11/2001","2/11/2001","3/11/2001","4/11/2001","5/11/2001","6/11/2001"]},title:{text:"Social Media",align:"left",style:{fontSize:"16px",color:"#666"}},fill:{type:"gradient",gradient:{shade:"dark",gradientToColors:["#fa5c7c"],shadeIntensity:1,type:"horizontal",opacityFrom:1,opacityTo:1,stops:[0,100,100,100]}},markers:{size:4,opacity:.9,colors:["#ffbc00"],strokeColor:"#fff",strokeWidth:2,style:"inverted",hover:{size:7}},yaxis:{min:-10,max:40,title:{text:"Engagement"}},grid:{row:{colors:["transparent","transparent"],opacity:.2},borderColor:"#f1f3fa"},responsive:[{breakpoint:600,options:{chart:{toolbar:{show:!1}},legend:{show:!1}}}]};(chart=new ApexCharts(document.querySelector("#line-chart-gradient"),options)).render();colors=["#ffbc00","#0acf97","#39afd1"];(dataColors=$("#line-chart-missing").data("colors"))&&(colors=dataColors.split(","));options={chart:{height:380,type:"line",zoom:{enabled:!1},animations:{enabled:!1}},stroke:{width:[5,5,4],curve:"straight"},series:[{name:"Peter",data:[5,5,10,8,7,5,4,null,null,null,10,10,7,8,6,9]},{name:"Johnny",data:[10,15,null,12,null,10,12,15,null,null,12,null,14,null,null,null]},{name:"David",data:[null,null,null,null,3,4,1,3,4,6,7,9,5,null,null,null]}],colors:colors,labels:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],grid:{row:{colors:["transparent","transparent"],opacity:.2},borderColor:"#f1f3fa",padding:{bottom:5}},legend:{offsetY:7}};(chart=new ApexCharts(document.querySelector("#line-chart-missing"),options)).render();colors=["#6c757d","#0acf97","#39afd1"];(dataColors=$("#line-chart-dashed").data("colors"))&&(colors=dataColors.split(","));options={chart:{height:380,type:"line",zoom:{enabled:!1}},dataLabels:{enabled:!1},stroke:{width:[3,5,3],curve:"straight",dashArray:[0,8,5]},series:[{name:"Session Duration",data:[45,52,38,24,33,26,21,20,6,8,15,10]},{name:"Page Views",data:[35,41,62,42,13,18,29,37,36,51,32,35]},{name:"Total Visits",data:[87,57,74,99,75,38,62,47,82,56,45,47]}],markers:{size:0,style:"hollow"},xaxis:{categories:["01 Jan","02 Jan","03 Jan","04 Jan","05 Jan","06 Jan","07 Jan","08 Jan","09 Jan","10 Jan","11 Jan","12 Jan"]},colors:colors,tooltip:{y:{title:{formatter:function(e){return"Session Duration"===e?e+" (mins)":"Page Views"===e?e+" per session":e}}}},grid:{borderColor:"#f1f3fa"},legend:{offsetY:7}};(chart=new ApexCharts(document.querySelector("#line-chart-dashed"),options)).render();for(var ts2=14844186e5,data=[],spikes=[5,-5,3,-3,8,-8],i=0;i<30;i++){innerArr=[ts2+=864e5,dataSeries[1][i].value];data.push(innerArr)}colors=["#0acf97"];(dataColors=$("#line-chart-stepline").data("colors"))&&(colors=dataColors.split(","));options={chart:{type:"line",height:350},stroke:{curve:"stepline"},dataLabels:{enabled:!1},series:[{data:[34,44,54,21,12,43,33,23,66,66,58]}],colors:colors,title:{text:"Stepline Chart",align:"left"},markers:{hover:{sizeOffset:4}}};(chart=new ApexCharts(document.querySelector("#line-chart-stepline"),options)).render();var lastDate=0,data=[];function getDayWiseTimeSeries(e,t,a){for(var o=0;o<t;){var r=e,s=Math.floor(Math.random()*(a.max-a.min+1))+a.min;data.push({x:r,y:s}),lastDate=e,e+=864e5,o++}}function getNewSeries(e,t){var a=e+864e5;lastDate=a,data.push({x:a,y:Math.floor(Math.random()*(t.max-t.min+1))+t.min})}function resetData(){data=data.slice(data.length-10,data.length)}getDayWiseTimeSeries(new Date("11 Feb 2017 GMT").getTime(),10,{min:10,max:90});colors=["#39afd1"];(dataColors=$("#line-chart-realtime").data("colors"))&&(colors=dataColors.split(","));options={chart:{height:350,type:"line",animations:{enabled:!0,easing:"linear",dynamicAnimation:{speed:2e3}},toolbar:{show:!1},zoom:{enabled:!1}},dataLabels:{enabled:!1},stroke:{curve:"smooth",width:[3]},colors:colors,series:[{data:data}],markers:{size:0},xaxis:{type:"datetime",range:7776e5},yaxis:{max:100},legend:{show:!1},grid:{borderColor:"#f1f3fa"}};(chart=new ApexCharts(document.querySelector("#line-chart-realtime"),options)).render();var dataPointsLength=10;window.setInterval(function(){getNewSeries(lastDate,{min:10,max:90}),chart.updateSeries([{data:data}])},2e3),window.setInterval(function(){resetData(),chart.updateSeries([{data:data}],!1,!0)},6e4);