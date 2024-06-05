// cursor pointer
const cursor = document.querySelector("#cursor");
const cursorBorder = document.querySelector("#cursor-border");
const cursorPos = {
    x: 0,
    y: 0
};
const cursorBorderPos = {
    x: 0,
    y: 0
};

document.addEventListener("mousemove", (e) => {
    cursorPos.x = e.clientX;
    cursorPos.y = e.clientY;

    cursor.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
});

requestAnimationFrame(function loop() {
    const easting = 8;
    cursorBorderPos.x += (cursorPos.x - cursorBorderPos.x) / easting;
    cursorBorderPos.y += (cursorPos.y - cursorBorderPos.y) / easting;

    cursorBorder.style.transform = `translate(${cursorBorderPos.x}px, ${cursorBorderPos.y}px)`;
    requestAnimationFrame(loop);
});

document.querySelectorAll("[data-cursor]").forEach((item) => {
    item.addEventListener("mouseover", (e) => {
        if (item.dataset.cursor === "pointer") {
            cursorBorder.style.backgroundColor = "rgba(255, 255, 255, .6)";
            cursorBorder.style.setProperty("--size", "30px");
        }
        if (item.dataset.cursor === "pointer2") {
            cursorBorder.style.backgroundColor = "white";
            cursorBorder.style.mixBlendMode = "difference";
            cursorBorder.style.setProperty("--size", "80px");
        }
    });
    item.addEventListener("mouseout", (e) => {
        cursorBorder.style.backgroundColor = "unset";
        cursorBorder.style.mixBlendMode = "unset";
        cursorBorder.style.setProperty("--size", "50px");
    });
});



// while hover color will change
function clrChange() {
    document.querySelector('.template').style.backgroundColor = '#0a76fa';
}

function clr() {
    document.querySelector('.template').style.backgroundColor = 'red';
}

function clr1() {
    document.querySelector('.template').style.backgroundColor = '#b1b2b3';
}

function clr2() {
    document.querySelector('.template').style.backgroundColor = 'red';
}

function restoreBackgroundColor() {
    document.querySelector('.template').style.backgroundColor = '#000000';
}


// Text path for
const degreeToRadian = (angle) => {
    return angle * (Math.PI / 180);
};

const radius = 80;
const diameter = radius * 2;

const circle = document.querySelector("#circle");
circle.style.width = `${diameter}px`;
circle.style.height = `${diameter}px`;

const text = circle.dataset.text;
const characters = text.split("");

const deltaAngle = 360 / characters.length;
const characterOffsetAngle = 8;
let currentAngle = -90;

characters.forEach((character, index) => {
    const span = document.createElement("span");
    span.innerText = character;
    const xPos = radius * (1 + Math.cos(degreeToRadian(currentAngle)));
    const yPos = radius * (1 + Math.sin(degreeToRadian(currentAngle)));

    const transform = `translate(${xPos}px, ${yPos}px)`;
    const rotate = `rotate(${(index * deltaAngle) + characterOffsetAngle}deg)`;
    span.style.transform = `${transform} ${rotate}`;

    currentAngle += deltaAngle;
    circle.appendChild(span);
});