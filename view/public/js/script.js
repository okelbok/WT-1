// calendar script

const datepicker = document.querySelector(".datepicker");
const dateInput = document.querySelector(".date-input");
const yearInput = datepicker.querySelector(".year-input");
const monthInput = datepicker.querySelector(".month-input");
const applyBtn = datepicker.querySelector(".apply");
const cancelBtn = datepicker.querySelector(".cancel");
const nextBtn = datepicker.querySelector(".next");
const prevBtn = datepicker.querySelector(".prev");
const dates = datepicker.querySelector(".dates");
const months = monthInput.textContent.split("\n");

let selectedDate = new Date();
let year = selectedDate.getFullYear();
let month = selectedDate.getMonth();

yearInput.addEventListener("change", function () {
    const min = parseInt(yearInput.getAttribute("min"));
    const max = parseInt(yearInput.getAttribute("max"));

    applyBtn.disabled = yearInput.value < min || yearInput.value > max;
})

applyBtn.addEventListener("click", async () => {
    dateInput.value = selectedDate.toLocaleDateString("ru-RU", {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
    });
    await displayData(true).then();
});

cancelBtn.addEventListener("click", async () => {
    dateInput.value = "";
    if (datepicker.querySelector(".selected") !== null) {
        datepicker.querySelector(".selected").classList.remove("selected");
    }
    selectedDate = new Date();
    displayDates();
    await displayData(false).then();
});

nextBtn.addEventListener("click", () => {
    if (month === 11) year++;
    month = (month + 1) % 12;
    displayDates();
});

prevBtn.addEventListener("click", () => {
    if (month === 0) year--;
    month = (month - 1 + 12) % 12;
    displayDates();
});

monthInput.addEventListener("change", () => {
    month = monthInput.selectedIndex;
    displayDates();
});

yearInput.addEventListener("change", () => {
    year = yearInput.value;
    displayDates();
});

const updateYearMonth = () => {
    monthInput.selectedIndex = month;
    yearInput.value = year;
};

const handleDateClick = (e) => {
    const button = e.target;

    const selected = dates.querySelector(".selected");
    selected && selected.classList.remove("selected");

    button.classList.add("selected");

    selectedDate = new Date(year, month, parseInt(button.textContent));
};

const displayDates = () => {
    updateYearMonth();

    dates.innerHTML = "";

    const lastOfPrevMonth = new Date(year, month, 0);
    let count = 0;

    for (let i = 1; i <= lastOfPrevMonth.getDay(); i++) {
        const text = lastOfPrevMonth.getDate() - lastOfPrevMonth.getDay() + i;
        const button = createButton(text, true, -1);
        dates.appendChild(button);
        count++;
    }

    const lastOfMonth = new Date(year, month + 1, 0);

    for (let i = 1; i <= lastOfMonth.getDate(); i++) {
        const button = createButton(i, false);
        button.addEventListener("click", handleDateClick);
        dates.appendChild(button);
        count++;
    }

    for (let i = 1; i <= 7 - (count % 7); i++) {
        const button = createButton(i, true, 1);
        dates.appendChild(button);
    }
};

const createButton = (text, isDisabled = false, type = 0) => {
    const currentDate = new Date();

    let comparisonDate = new Date(year, month + type, text);

    const isToday =
        currentDate.getDate() === text &&
        currentDate.getFullYear() === parseInt(year) &&
        currentDate.getMonth() === month;

    const selected = selectedDate.getTime() === comparisonDate.getTime();

    const button = document.createElement("button");
    button.textContent = text;
    button.disabled = isDisabled;
    button.classList.toggle("today", isToday && !isDisabled);
    button.classList.toggle("selected", selected);
    return button;
};

displayDates();

// main script

// there could be your API Keys...



const catAPI_URL = "https://api.thecatapi.com/v1/images/search";
const astroAPI_URL_Positions = "https://api.astronomyapi.com/api/v2/bodies/positions";
const astroAPI_URL_Moon = "https://api.astronomyapi.com/api/v2/studio/moon-phase";

const currentDate = document.querySelector(".current-date-name");
const infoWrapper = document.querySelector(".info-container");
const positionsWrapper = document.querySelector(".positions-wrapper");
const moonImage = document.querySelector(".moon-phase");
const catWrapper = document.querySelector(".cat-container");
const catImage = document.querySelector(".cat");

let longitude = 0;
let latitude = 0;
let date = "";
let time = "";

const pictures = [
    "sun.png",
    "moon.png",
    "mercury.png",
    "venus.png",
    "earth.png",
    "mars.png",
    "jupiter.png",
    "saturn.png",
    "uranus.png",
    "neptune.png",
    "pluto.png"
]

async function getNewCat() {
    const requestURL = `${catAPI_URL}?size=small&mime_types=gif`;
    return await fetch(requestURL, {
        method: "GET",
        headers: {
            "x-api-key": catAPI_KEY,
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(response => response[0].url)
        .catch(error => console.log(error));
}

async function getUserData() {
    const position = await new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject);
    });

    latitude = position.coords.latitude;
    longitude = position.coords.longitude;

    date = selectedDate.toLocaleDateString("sv-SE");

    const hours = (selectedDate.getHours() > 9) ? selectedDate.getHours().toString() : ("0" + selectedDate.getHours().toString());
    const minutes = (selectedDate.getMinutes() > 9) ? selectedDate.getMinutes().toString() : ("0" + selectedDate.getMinutes().toString());
    const seconds = (selectedDate.getSeconds() > 9) ? selectedDate.getSeconds().toString() : ("0" + selectedDate.getSeconds().toString());
    time = `${hours}%3A${minutes}%3A${seconds}`;
}

async function getPositions() {
    const requestURL = `${astroAPI_URL_Positions}?longitude=${longitude}&latitude=${latitude}&elevation=0&from_date=${date}&to_date=${date}&time=${time}&output=rows`;

    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();

        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === this.DONE) {
                if (this.status === 200) {
                    resolve(this.responseText);
                }
                else {
                    reject(this.statusText);
                }
            }
        });

        xhr.open("GET", requestURL);
        xhr.setRequestHeader("Authorization", astroAPI_KEY);

        xhr.send();
    })
        .catch(error => console.log(error));
}

function formBodyInfo(bodyData) {
    const endl = "\n";
    let bodyInfo = "";
    const position = bodyData["positions"][0]["position"];
    const extraInfo = bodyData["positions"][0]["extraInfo"];

    bodyInfo += "Horizontal coordinates: " + endl;
    bodyInfo += "  - altitude: " + position["horizontal"]["altitude"]["string"] + endl;
    bodyInfo += "  - azimuth: " + position["horizontal"]["azimuth"]["string"] + endl + endl;

    bodyInfo += "Equatorial coordinates: " + endl;
    bodyInfo += "  - right ascension: " + position["equatorial"]["rightAscension"]["string"] + endl;
    bodyInfo += "  - declination: " + position["equatorial"]["declination"]["string"] + endl + endl;

    bodyInfo += "Constellation: " + position["constellation"]["name"] + endl + endl;

    if (bodyData["body"]["name"] !== "Earth") {
        bodyInfo += "Elongation: " + extraInfo["elongation"] + endl;
        bodyInfo += "Magnitude: " + extraInfo["magnitude"] + endl;
    }

    if (bodyData["body"]["name"] === "Moon") {
        bodyInfo += endl + "Phase characteristics: " + endl;
        bodyInfo += "  - angle: "+ extraInfo["phase"]["angel"] + endl;
        bodyInfo += "  - fraction: " + extraInfo["phase"]["fraction"] + endl;
    }

    return bodyInfo;
}

function createCard(bodyName, bodyInfo, index) {
    const card = document.createElement("div");
    card.classList.add("data-card");

    const cardHeader = document.createElement("div");
    cardHeader.classList.add("data-card-header");

    const bodyImage = document.createElement("img");
    bodyImage.classList.add("body-image");
    bodyImage.setAttribute("src", "/AstroCalendar/view/public/images/" + pictures[index]);
    bodyImage.setAttribute("alt", bodyName);

    cardHeader.appendChild(bodyImage);

    const bodyHeader = document.createElement("h3");
    bodyHeader.classList.add("body-name");
    bodyHeader.innerText = bodyName;

    cardHeader.appendChild(bodyHeader);

    card.appendChild(cardHeader);

    const bodyInfoWrapper = document.createElement("div");
    bodyInfoWrapper.classList.add("body-info");
    bodyInfoWrapper.innerText = bodyInfo;

    card.appendChild(bodyInfoWrapper);

    return card;
}

function displayBodyPositions(data) {
    let bodyName = "";
    let bodyInfo = "";
    for (let i = 0; i < data.length; i++) {
        bodyName = data[i]["body"]["name"];
        bodyInfo = formBodyInfo(data[i]);

        positionsWrapper.appendChild(createCard(bodyName, bodyInfo, i));
    }
}

async function getMoonPhase() {
    const data = `{\"style\":{\"moonStyle\":\"default\",\"backgroundStyle\":\"stars\",\"backgroundColor\":\"#000000\",\"headingColor\":\"#ffffff\",\"textColor\":\"#ffffff\"},\"observer\":{\"latitude\":${latitude},\"longitude\":${longitude},\"date\":\"${date}\"},\"view\":{\"type\":\"portrait-simple\",\"parameters\":{}}}`;

    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();

        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === this.DONE) {
                if (this.status === 200) {
                    resolve(this.responseText);
                }
                else {
                    reject(this.statusText);
                }
            }
        });

        xhr.open("POST", astroAPI_URL_Moon);
        xhr.setRequestHeader("Authorization", astroAPI_KEY);

        xhr.send(data);
    })
        .catch(error => console.log(error));
}

function displayMoonEvents(data) {
    moonImage.setAttribute("src", data);
}

function removeAllCards() {
    let children = document.querySelectorAll(".data-card");
    children.forEach(card => {
        card.remove();
    })
}

function changeAttributes(isApplied) {
    if (isApplied) {
        currentDate.textContent = months[selectedDate.getMonth() + 1] + " " + selectedDate.getDate() + ", " + selectedDate.getFullYear();
        infoWrapper.style.display = "flex";
        catWrapper.style.display = "none";
        removeAllCards();
        moonImage.setAttribute("src", "");
        catImage.setAttribute("src", "/AstroCalendar/view/public/images/cat.gif");
    }
    else {
        currentDate.textContent = "No date selected :( But check this out:";
        infoWrapper.style.display = "none";
        catWrapper.style.display = "flex";
    }
}

async function displayData(isApplied) {
    changeAttributes(isApplied);
    if (isApplied) {
        let data = null;
        await getUserData();

        // get bodies positions
        await getPositions().then(response => data = response);
        if (data !== null) {
            data = Object.values(JSON.parse(data))[0]["rows"];
            displayBodyPositions(data);
        }

        data = null;
        // get Moon events
        await getMoonPhase().then(response => data = response);
        if (data !== null) {
            data = Object.values(JSON.parse(data))[0]["imageUrl"];
            displayMoonEvents(data);
        }
    }
    else {
        let src = await getNewCat().then();
        if (src !== undefined) {
            catImage.setAttribute("src", src);
        }
    }
}

await displayData(true).then();