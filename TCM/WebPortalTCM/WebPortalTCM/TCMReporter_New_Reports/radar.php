<html> 
  <head> 
    <title>Radar!</title> 
    <script type="text/javascript"> 
      Array.max = function( array ){ 
        return Math.max.apply( Math, array ); 
      }; 

      colors = ["FFFF00", 
                "FF00FF", 
                "00FFFF", 
                "0000FF", 
                "00FF00", 
                "FF0000"] 

      function RadarDataSet() { 
        var ds_name = ""; 
        var ds_data = [1, 2, 3, 4]; 
        var ds_color = colors.pop() + "FF"; 
        var ds_fill = ds_color.substring(0, 6) + "33"; 
        var ds_lineweight = 2; 

        this.SetName = SetName; 
        this.SetData = SetData; 
        this.SetColor = SetColor; 
        this.SetFill = SetFill; 
        this.SetLineWeight = SetLineWeight; 

        this.GetName = GetName; 
        this.GetData = GetData; 
        this.GetColor = GetColor; 
        this.GetFill = GetFill; 
        this.GetLineWeight = GetLineWeight; 

        function GetName() { return ds_name.replace(" ", "+"); } 
        function GetData() { return ds_data; } 
        function GetColor() { return ds_color; } 
        function GetFill() { return ds_fill; } 
        function GetLineWeight() { return ds_lineweight; } 

        function SetName(name) { ds_name = name; } 
        function SetData(data) { 
          ds_data = data; 
          ds_data.push(ds_data[0]); 
        } 
        function SetColor(color) { ds_color = color; } 
        function SetFill(fill) { ds_fill = fill; } 
        function SetLineWeight(lineweight) { ds_lineweight = 
lineweight; } 
      } 

      function RadarMaker() { 
        var r_title = ""; 
        var r_radars = []; 
        var r_cht = "r"; 
        var r_width = 250; 
        var r_height = 250; 
        var r_labels = []; 
        var r_legend = ""; 
        this.SetTitle = SetTitle; 
        this.SetLabels = SetLabels; 
        this.SetLegend = SetLegend; 
        this.SetDimensions = SetDimensions; 
        this.NewRadar = NewRadar; 
        this.GenerateURL = GenerateURL; 

        function SetTitle(title) { r_title = title; } 
        function SetLabels(labels) { r_labels = labels; } 
        function SetLegend(legend) { r_legend = legend; } 
        function SetDimensions(width, height) { 
          r_width = width; 
          r_height = height; 
        } 

        function NewRadar() { 
          var radar = new RadarDataSet(); 
          r_radars.push(radar); 
          return radar; 
        } 

        function GenerateURL() { 
          var params = {}; 

          var name_array = []; 
          var max_data = 0; 
          var data_array = []; 
          var color_array = []; 
          var fill_array = []; 
          var lineweight_array = []; 
          for (var i in r_radars) { //build each radar data set into 
big arrays. 
            name_array.push(r_radars[i].GetName()); 
            data_array.push(r_radars[i].GetData().join(",")); 
            if (Array.max(r_radars[i].GetData()) > max_data) {max_data 
= Array.max(r_radars[i].GetData());} //keep track of highest number 
        color_array.push(r_radars[i].GetColor()); 
            fill_array.push(["B", r_radars[i].GetFill(), i, i+1, 
0].join(",")); //Fill strings should resemble "B,AABBCCDD,0,1,#" 
  
lineweight_array.push([r_radars[i].GetLineWeight(),"1","0"].join(",")); 
          } 

          params['cht'] = r_cht;                        //data type 
          params['chs'] = r_width + "x" + r_height;     //dimensions 
          if (r_title != "") { params['chtt'] = r_title.replace(" ", 
"+"); } 
          if (r_legend != "") { 
            params['chdl'] = name_array.join("|"); 
            params['chdlp'] = r_legend; 
          } 

          params['chxt'] = "x";                         //axes 
          params['chds'] = "0," + max_data;             //data scale 

          params['chco'] = color_array.join(",");       //line colors 
          params['chm'] = fill_array.join("|");         //line fills 
          params['chls'] = lineweight_array.join("|");  //line sizes 
          params['chxl'] = "0:|" + r_labels.join("|");  //axis labels 
          params['chd'] = "t:" + data_array.join("|");  //data 


          var param_array = [] 
          for (i in params) { param_array.push(i + "=" + params[i]); } 
          var url = "http://chart.apis.google.com/chart?" + 
param_array.join("&"); 
          return url; 
        } 
      } 

      var radar_maker = new RadarMaker(); 
      radar_maker.SetDimensions(400, 250); 
      radar_maker.SetLabels(["Stream", "Chaos", "Freeze", "Air", 
"Voltage"]); 
      radar_maker.SetTitle("DDR Song Comparison"); 
      radar_maker.SetLegend("r"); 

      var radar_data = radar_maker.NewRadar(); 
      radar_data.SetName("DDR Song"); 
      radar_data.SetData([1,2,3,5,2]); 
      radar_data.SetLineWeight(2); 

      var radar_data2 = radar_maker.NewRadar(); 
      radar_data2.SetName("Other DDR Song"); 
      radar_data2.SetData([5,4,1,1,1]); 
      radar_data2.SetLineWeight(2); 

      var radar_data2 = radar_maker.NewRadar(); 
      radar_data2.SetName("Third DDR Song"); 
      radar_data2.SetData([2,3,1,5,5]); 
      radar_data2.SetLineWeight(2); 

      document.write(radar_maker.GenerateURL()); 
      document.write("<br />"); 
      document.write("<img src=\"" + radar_maker.GenerateURL() + 
"\">"); 
    </script> 
  </head>