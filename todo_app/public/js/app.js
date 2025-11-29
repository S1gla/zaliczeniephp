let tasks = [];
let filter = 'all';

const API_URL = "/todo_app/api/tasks.php";

async function loadTasks() {
  const res = await fetch(API_URL);
  tasks = await res.json();
  renderTasks();
}

async function addTask() {
  const input = document.getElementById('taskInput');
  const text = input.value.trim();
  if (!text) return;

  await fetch(API_URL, {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({ text })
  });

  input.value = "";
  loadTasks();
}

async function toggleTask(id) {
  const task = tasks.find(t => t.id == id);
  await fetch(API_URL, {
    method: "PUT",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({
      id,
      text: task.text,
      completed: task.completed ? 0 : 1
    })
  });

  loadTasks();
}

async function editTask(id) {
  const task = tasks.find(t => t.id == id);
  const newText = prompt("Edytuj zadanie:", task.text);
  if (!newText) return;

  await fetch(API_URL, {
    method: "PUT",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({
      id,
      text: newText,
      completed: task.completed
    })
  });

  loadTasks();
}

async function deleteTask(id) {
  await fetch(API_URL, {
    method: "DELETE",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({ id })
  });

  loadTasks();
}

function setFilter(f) {
  filter = f;
  renderTasks();
}

function renderTasks() {
  const list = document.getElementById('todoList');
  list.innerHTML = '';

  let filtered = tasks.filter(t =>
    filter === 'all' ? true :
    filter === 'active' ? t.completed == 0 :
    t.completed == 1
  );

  filtered.forEach((task) => {
    const div = document.createElement('div');
    div.className = 'todo-item';

    div.innerHTML = `
      <span 
        class="${task.completed ? 'completed' : ''}" 
        onclick="toggleTask(${task.id})"
        title="Dodano: ${new Date(task.date_added).toLocaleString('pl-PL')}"
      >${task.text}</span>

      <div class="todo-buttons">
        <button class="btn-edit" onclick="editTask(${task.id})">Edytuj</button>
        <button class="btn-delete" onclick="deleteTask(${task.id})">Usuń</button>
      </div>
    `;

    list.appendChild(div);
  });
}

document.getElementById('addBtn').onclick = addTask;
document.getElementById('sortSelect').onchange = renderTasks;

loadTasks();
