const form = document.querySelector("form"), // Select the form element
fileAdd = document.querySelector(".fileadd"), // Select the button to add file
fileInput = document.querySelector(".file-input"), // Select the file input element
progressArea = document.querySelector(".progress-area"), // Select the area to show upload progress
uploadedArea = document.querySelector(".uploaded-area"); // Select the area to show uploaded files

// Trigger file input click when file add button is clicked
fileAdd.addEventListener("click", () =>{
  fileInput.click();
});

// Handle file input change event
fileInput.onchange = ({target})=>{
  let file = target.files[0]; // Get the selected file
  if(file){
    let fileName = file.name; // Get the file name
    if(fileName.length >= 12){
      let splitName = fileName.split('.'); // Split the file name and extension
      fileName = splitName[0].substring(0, 13) + "... ." + splitName[1]; // Shorten the file name if it's too long
    }
    uploadFile(fileName); // Call the upload function with the file name
  } 
}

// Function to upload the file
function uploadFile(name){
  let xhr = new XMLHttpRequest(); // Create a new XMLHttpRequest object
  xhr.open("POST", "php/upload.php"); // Set the request method and URL

  // Event listener for upload progress
  xhr.upload.addEventListener("progress", ({loaded, total}) =>{
    let fileLoaded = Math.floor((loaded / total) * 100); // Calculate the file upload percentage
    let fileTotal = Math.floor(total / 1000); // Calculate the total file size in KB
    let fileSize;
    (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024*1024)).toFixed(2) + " MB"; // Convert file size to MB if larger than 1024 KB

    // Create HTML for the progress bar
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Uploading</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
    uploadedArea.classList.add("onprogress"); // Add class to indicate ongoing upload
    progressArea.innerHTML = progressHTML; // Display the progress bar

    // Check if file upload is complete
    if(loaded == total){
      progressArea.innerHTML = ""; // Clear the progress area
      // Create HTML for the uploaded file
      let uploadedHTML = `<li class="row">
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span class="name">${name} • Uploaded</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
      uploadedArea.classList.remove("onprogress"); // Remove the progress class
      uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML); // Add the uploaded file to the uploaded area
    }
  });

  let data = new FormData(form); // Create a FormData object with the form data
  xhr.send(data); // Send the form data to the server
}
