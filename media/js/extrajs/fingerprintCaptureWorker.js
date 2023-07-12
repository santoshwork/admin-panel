self.addEventListener("message", function(event) {
    var fingerVal = event.data;

    try {
        var res = CaptureFinger(fingerVal);

        if (res.httpStaus) {
            var message = {};
            message.success = true;
            message.fingerVal = fingerVal;

            if (res.data.ErrorCode == "0") {
                message.bitmapData = res.data.BitmapData;
            } else {
                message.success = false;
            }

            self.postMessage(message);
        } else {
            console.log(res);
        }
    } catch (e) {
        console.log(e);
        self.postMessage({ success: false });
    }
});


let flag = 0;
let quality = 90; //(1 to 100) (recommanded minimum 55)
let timeout = 20; // seconds (minimum=10(recommanded), maximum=60, unlimited=0 )


function captureFinger(fingerVal) {
	
	try { 	
					
		var res = CaptureFinger(quality, timeout);
		
		if (res.httpStaus) {
				flag = 1;
			
			if (res.data.ErrorCode == "0") {
				if( fingerVal<5 ) {
					alert("Image"+fingerVal+" is captured successfully. Proceed to capture Image"+(fingerVal+1))
					document.getElementById('finger'+fingerVal+'Value').value = "data:image/bmp;base64,"+ res.data.BitmapData; 
				} else if( fingerVal== 5) {
					alert("All Images are captured successfully. Please Proceed to save the information")
					document.getElementById('finger'+fingerVal+'Value').value = "data:image/bmp;base64,"+ res.data.BitmapData;
				}
				                  
			} else {
				alert("Image not captured.")
				
			}
		}
		else {
			console.log(res);
		}
	}
	catch (e) {
		console.log(e);
	}
	return false;
}