
	function Filevalidation() {
        const fi = document.getElementById('fileToUpload');
        // Check if any file is selected.
        if (fi.files.length > 0) {
            for ( i = 0; i <= fi.files.length - 1; i++) {
  
                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
				document.getElementById('size').innerHTML = '<b>Supporting Document </b>';
                // The size of the file.
                if (file >= 4096) {
                    alert(
                      "File too Big, please select a file less than 4mb");
                } else if (file < 1) {
                    alert(
                      "File too small, please select a file greater than 1kb");
                } else {
                    document.getElementById('size').innerHTML = '<b>Supporting Document '
                    + file + '</b> KB';
                
					var filePath = fi.value;
					// Allowing file type
					var allowedExtensions = 
							/(\.jpg|\.jpeg|\.png|\.gif)$/i;
					  
					if (!allowedExtensions.exec(filePath)) {
						// Allowing file type
							var allowedExtensions = 
							/(\.pdf)$/i;
							  document.getElementById('imagePreview').innerHTML =  '';
							  document.getElementById('confirmupload').innerHTML =  '';
							if (!allowedExtensions.exec(filePath)) {
								alert('Invalid file type');
								fi.value = '';
								
								return false;
							} else {
								document.getElementById('confirmupload').innerHTML =  
								'<input type="submit" name="Acceptfile" id="submit-button" title="Confirm that the selected file is your choice" formtarget="_blank" value ="Verify Doc" formaction="<?php echo $_SESSION['applicationbase'].'scan.php' ;?>"/>';
							}
					} 
					else 
					{
					  
						// Image preview
						if (fi.files && fi.files[0]) {
							var reader = new FileReader();
							reader.onload = function(e) {
								document.getElementById(
									'confirmupload').innerHTML = 
									'<input type="submit" name="Acceptfile" id="submit-button" formtarget="_blank" value ="Verify Doc" formaction="<?php echo $_SESSION['applicationbase'].'scan.php' ;?>"/> <br />';
								document.getElementById(
									'imagePreview').innerHTML = 
									'<img width="95%" src="' + e.target.result
									+ '"/>';
							};
							  
							reader.readAsDataURL(fi.files[0]);
						}
					}
				
				
				
				}
            }
        }
    }
	
