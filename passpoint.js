
    
        function trigger(event, number){
		
          var x = event.clientX;
          var y = event.clientY;
          var coords = x + "," + y;
          var sumCoords = " "+coords;
          //var clickpoint = cp;

         
            
          //var input = document.getElementsByClassName("user");
          var userNo = "user"+number;
          var input = document.getElementById(userNo);

            var arr = input.value.split(" ");
            console.log(arr.length);
              
                 input.value += sumCoords;
            }

             

            function validateForm() {
                var cp = document.getElementById('cp2').value;
                if(cp=="satu"){
                    var clickpoint=8;
                }
                else if(cp=="dua"){
                    var clickpoint=4;
                }
                else if(cp=="empat"){
                    var clickpoint=2;
                }
                var x = document.forms["myForm"].getElementsByClassName("userIn");
                //clickpoint = cp;
                //alert (clickpoint);
                var i;

                for(i=0;i<x.length;i++){

                    var input = x[i];
                    console.log(i+":"+x[i].value);
                    var arr = input.value.trim().split(" ");
                    var len = arr.length;
                    console.log(len+":"+clickpoint);
                    
                        if(len >clickpoint){
                            alert('Extra '+(len-clickpoint)+' input from image '+(i+1)+'. Please insert the clickpoint for image '+(i+1)+' again');
                            input.value = "";
                             return false;
                        }
                        else if(len <clickpoint){
                            alert('Input '+(i+1)+' is not enough');
                            input.value = "";
                             return false;
                        }
                        else if(input.value==""){
                            alert('Input '+i+' is empty');
                            input.value = "";
                             return false;
                        }
                        
                       
                }
            }
        
            function check(dbIN, userIN, username, uuu){
				console.clear();
                var test = dbIN.split("||");
                var user = userIN.split("||");
                var i;
                var flag = true;
				 var count =0;
                
                
                if(test.length != user.length){
                    console.log(dbIN+':'+userIN);
                    alert('Picture amount different');
                    console.log(test.length+':'+user.length);
                }
                else{
                    for(i=0; i<test.length; i++){
                        console.log('db  -'+dbIN);
                        console.log('user-'+userIN);
                        
                        if(test[i]=="" ||user[i]=="")
                            {
                                alert('Some input not filled');
                                //flag = false;
								count++;
                                break;
                            }
                        if(test[i].length!=user[i].length)
                        {
                            console.log(test[i].length+':'+user[i].length);
                            alert('Different input amount');
							count++;
                            //flag = false;
                            break;
                        }
                        
                        if(!checkCoordinate(test[i], user[i])){
                            alert('Different from DB');
							count++;
                           //flag = false;
                            break;
                        }
                    }
                    if(count == 0){
                        alert('success');
                        //console.log('db  -'+dbIN);
                        //console.log('user-'+userIN);
                        window.location.href='reset-password.php?name='+username+'&ran='+uuu;
                    }
                    else{alert('Failed');}
                    
                }

                var elements = document.getElementsByTagName("input");
                for (var ii=0; ii < elements.length; ii++) {
                if (elements[ii].type == "text") {
                    elements[ii].value = "";
                }
                }
            }
        
        function checkCoordinate(dbStr, userStr){
            var dbx = [];
            var dby = [];
            var x = [];
            var y = [];
            var flag = false;
			var trueCount = 0;
            var tol = 100;
            //Database Coordinate
            var dbCoord = dbStr;
            dbCoord = dbCoord.trim(dbCoord);
            var dbCoord = dbCoord.split(" ");   //Separate coordinate based on space

            //Input Coordinate
            var rawCoord = userStr;
            rawCoord = rawCoord.trim(rawCoord);
            var Coord = rawCoord.split(" ");    //Separate coordinate based on space
			
			if(dbCoord.length != Coord.length){
               alert('INSUFFICIENT');
                return false;
             }
			 else{
				 var skip = [];
				//Differentiate x and y
				for(var i=0;i<Coord.length;i++){
					//for user input point
					var point = Coord[i].split(",");
					console.log(point);
					 x[i] =  parseInt(point[0]);
					 y[i] =  parseInt(point[1]);
					 
					 for(var j=0;j<dbCoord.length;j++){
						//Check if j has been mark
                        var signal = false;
                        for(var k=0;k<skip.length;k++){
                            if(j == skip[k]){
                                signal=true;   
                            }
                        }
						if(signal){
                            console.log("j:"+j+" skipped");
                            continue;
                        }
						else{
							//for database point
							var sample = dbCoord[j].split(",");
							 console.log('db,j'+j);
                            console.log(sample);
							dbx[j] =  parseInt(sample[0]);
							dby[j] =  parseInt(sample[1]);
							
							if(x[i]<(dbx[j]-tol)||x[i]>(dbx[j]+tol)||y[i]<(dby[j]-tol)||y[i]>(dby[j]+tol)){
                                //alert('Out of range:'+x[i]+','+y[i]+' AND '+dbx[i]+','+dby[i]);
                                //console.log('FALSE');
                                //flag = false;
                                //break;
                            }
                            else{
                                trueCount++;
                                console.log('Correct:'+trueCount);
                                //console.log('j'+j);
                                 skip.push(j);
                                break;
                                //console.log('else');
                                //flag = true;
                                //alert('Nice');
                            }
						}
					}
				}

			if(trueCount==dbCoord.length){return true;}
            else{return false;}

			 }

            //console.log(x);
            //console.log(y);
    }
   

        
    
       
    /*
            //tekan gambar
            function kira(kira){
               input:checked ~ label {
                opacity: 0.5;
                }
            
            //support in ie8 
            
                $(kira).click(function () {
                    $('label[for=' + this.id + ']').toggleClass('checked');
                });
                
                label.checked {
                    opacity: 0.5;
                }      

            }
            */
              
