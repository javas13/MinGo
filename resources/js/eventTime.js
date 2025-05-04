// let date = new Date('March 22 2025 00:00:00');
let date2 = document.querySelector('.event-date-value-js').value;
let date = Date.parse(date2);

function counts(){
    let now = new Date();
    let gap = date - now;

    let days = Math.floor(gap / 1000 / 60 / 60 / 24);
    let hours = Math.floor(gap / 1000 / 60 / 60 ) % 24;
    let minutes = Math.floor(gap / 1000 / 60) % 60;
    let seconds = Math.floor(gap / 1000 ) % 60;

    //Добавляем нули если значение меньше 10 чтобы было например 09
    days = days < 10 ? '0' + days : days;
    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    let daysString = days.toString();
    let hoursString = hours.toString();
    let minutesString = minutes.toString();
    let secondsString = seconds.toString();

    document.getElementById('sec_tens').innerHTML = secondsString[0];
    document.getElementById('sec').innerHTML = secondsString[1];

    document.getElementById('min_tens').innerHTML = minutesString[0];
    document.getElementById('min').innerHTML = minutesString[1];

    document.getElementById('hours_tens').innerHTML = hoursString[0];
    document.getElementById('hours').innerHTML = hoursString[1];

    document.getElementById('days_tens').innerHTML = daysString[0];
    document.getElementById('days').innerHTML = daysString[1];
}

counts();

setInterval(counts, 1000);