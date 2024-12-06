// Game settings
const rows = 15; // Number of rows
const cols = 15; // Number of columns
const numMines = 30; // Number of mines

let board = []; // 2D array for the board
let revealed = []; // Tracks revealed cells

let scoreDiv = document.getElementById("score");
let score = 0;

// Start a new game
function startGame() {
    if (timer !== null){
        stopTimer();
        resetTimer(); 
    }
    startTimer();
    createBoard();
    placeMines();
    calculateNumbers();
    renderBoard();
}

// Create the board structure
function createBoard() {
    board = Array.from({ length: rows }, () => Array(cols).fill(0));
    revealed = Array.from({ length: rows }, () => Array(cols).fill(false));
}

// Randomly place mines on the board
function placeMines() {
    let minesPlaced = 0;
    while (minesPlaced < numMines) {
        const row = Math.floor(Math.random() * rows);
        const col = Math.floor(Math.random() * cols);
        if (board[row][col] === 0) {
            board[row][col] = "M"; // Mark as mine
            minesPlaced++;
        }
    }
}

// Calculate numbers (adjacent mine counts)
function calculateNumbers() {
    for (let r = 0; r < rows; r++) {
        for (let c = 0; c < cols; c++) {
            if (board[r][c] === "M") continue;

            let mineCount = 0;
            for (let dr = -1; dr <= 1; dr++) {
                for (let dc = -1; dc <= 1; dc++) {
                    const nr = r + dr;
                    const nc = c + dc;
                    if (nr >= 0 && nr < rows && nc >= 0 && nc < cols && board[nr][nc] === "M") {
                        mineCount++;
                    }
                }
            }
            board[r][c] = mineCount;
        }
    }
}

// Render the board in the HTML
function renderBoard() {
    const gameBoard = document.getElementById("game-board");
    gameBoard.innerHTML = ""; // Clear previous board

    const table = document.createElement("table");

    for (let r = 0; r < rows; r++) {
        const tr = document.createElement("tr");
        for (let c = 0; c < cols; c++) {
            const td = document.createElement("td");
            td.dataset.row = r;
            td.dataset.col = c;
            td.addEventListener("click", handleCellClick);
            if (board[r][c] === "M") { // Check if cell contains a mine
                td.textContent = "M"; // Display "M" if it's a mine
            }
            tr.appendChild(td);
        }
        table.appendChild(tr);
    }

    gameBoard.appendChild(table);
}

// Handle cell click
function handleCellClick(event) {
    const row = parseInt(event.target.dataset.row);
    const col = parseInt(event.target.dataset.col);

    if (revealed[row][col]) return; // Ignore already revealed cells
    revealCell(row, col);
}

// Reveal a cell
function revealCell(row, col) {
    if (row < 0 || row >= rows || col < 0 || col >= cols || revealed[row][col]) return;

    const cell = document.querySelector(`td[data-row="${row}"][data-col="${col}"]`);
    revealed[row][col] = true;

    if (board[row][col] === "M") {
        cell.textContent = "M";
        cell.classList.add("mine");
        alert("Game Over!");
        startGame();
        return;
    }

    if (board[row][col] > 0) {
        cell.textContent = board[row][col];
        cell.classList.add("revealed");
    } else {
        cell.classList.add("revealed");
        // Recursively reveal adjacent cells if no adjacent mines
        for (let dr = -1; dr <= 1; dr++) {
            for (let dc = -1; dc <= 1; dc++) {
                revealCell(row + dr, col + dc);
            }
        }
    }

}

let timer = null; // Stores the interval ID
let elapsedTime = 0; // Tracks time in seconds

// Start the timer
function startTimer() {
    if (timer !== null) return; // Prevent multiple timers

    timer = setInterval(() => {
        elapsedTime++; // Increment time by 1 second
        document.getElementById('score').textContent = elapsedTime; // Update the timer display
    }, 1000); // 1000ms = 1 second
}

// Stop the timer
function stopTimer() {
    clearInterval(timer); // Stops the timer
    timer = null; // Reset the interval ID
}

// Reset the timer
function resetTimer() {
    stopTimer(); // Stop the timer if running
    elapsedTime = 0; // Reset elapsed time
    document.getElementById('timer').textContent = elapsedTime; // Reset display
}
