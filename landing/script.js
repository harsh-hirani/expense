function toggleSlider() {
    const slider = document.getElementById("slider");
    if (slider.style.width === "250px") {
        slider.style.width = "0";
    } else {
        slider.style.width = "250px";
    }
}

function footer_alert(){
    alert("your response have been saved!")
}


document.getElementById("footer_submit").addEventListener("click",footer_alert)
