// Game settings
const rows = 8; // Number of rows
const cols = 8; // Number of columns
const numMines = 10; // Number of mines

let board = []; // 2D array for the board
let revealed = []; // Tracks revealed cells

// Start a new game
function startGame() {
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
        cell.textContent = "💣";
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
