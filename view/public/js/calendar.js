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

async function sendPOSTRequest() {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/AstroCalendar');

    xhr.send(null);
}

yearInput.addEventListener("change", async () => {
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

    document.cookie = `selectedDate=${dateInput.value}`;
    displayDates();
    document.cookie = "isApplied=true";
    sendPOSTRequest().then();
});

cancelBtn.addEventListener("click",  () => {
    dateInput.value = "";
    if (datepicker.querySelector(".selected") !== null) {
        datepicker.querySelector(".selected").classList.remove("selected");
    }
    selectedDate = new Date();

    document.cookie = `selectedDate=`;
    displayDates();
    document.cookie = "isApplied=false";
    sendPOSTRequest().then();
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