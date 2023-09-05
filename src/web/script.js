// Nehmen wir an, der X-Wert liegt zwischen 0 und 4
// Passen Sie diesen Wert entsprechend an
const x = 2;

// Ändern Sie die Hintergrundfarbe der Lampen je nach X-Wert
for (let i = 1; i <= 4; i++) {
    const lamp = document.getElementById(`lamp${i}`);
    if (i <= x) {
        lamp.style.backgroundColor = "green";
    } else {
        lamp.style.backgroundColor = "red";
    }
}