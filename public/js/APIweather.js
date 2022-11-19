function init() {
    $.ajax({
        url: "https://api.open-meteo.com/v1/forecast?latitude=48.85&longitude=2.35&current_weather=true&timezone=CET",
        success: function (response) {
            let time = response.current_weather.time;
            let timeToDisplay = time.replace('T', ' ');
            let display = $('<div class="card mt-3" style="width: 18rem;" </div><div class = "card-body" > <h5 class="card-title mb-3"> Temperature of the day </h5><h6 class="card-subtitle mb-2 text-muted">' + timeToDisplay + '</h6 ><p class="card-text"> Temperature : ' + response.current_weather.temperature + ' °C </p><p class="card-text">Wind speed : ' + response.current_weather.windspeed + ' km/h </p></div ></div> ');

            $('.container').prepend(display);
        }
    })
};

document.addEventListener('DOMContentLoaded', init);