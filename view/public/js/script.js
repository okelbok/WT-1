let selectedDate = new Date();

async function getUserData() {
    let longitude;
    let latitude;
    let time;

    const position = await new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject);
    });

    latitude = position.coords.latitude;
    longitude = position.coords.longitude;

    document.cookie = `latitude=${latitude}`;
    document.cookie = `longitude=${longitude}`;

    const hours = (selectedDate.getHours() > 9) ? selectedDate.getHours().toString() : ("0" + selectedDate.getHours().toString());
    const minutes = (selectedDate.getMinutes() > 9) ? selectedDate.getMinutes().toString() : ("0" + selectedDate.getMinutes().toString());
    const seconds = (selectedDate.getSeconds() > 9) ? selectedDate.getSeconds().toString() : ("0" + selectedDate.getSeconds().toString());
    time = `${hours}%3A${minutes}%3A${seconds}`;

    document.cookie = `time=${time}`;
}

document.addEventListener('DOMContentLoaded', () => {
    getUserData().then();
})