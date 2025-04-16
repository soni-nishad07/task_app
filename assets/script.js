// function fetchTasks() {
//   fetch('task_crud.php', {
//     method: 'POST',
//     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//     body: 'action=read'
//   }).then(res => res.json()).then(data => {
//     let html = '<table><tr><th>Title</th><th>Deadline</th><th>Priority</th><th>Action</th></tr>';
//     data.forEach(t => {
//       html += `<tr><td>${t.title}</td><td>${t.deadline}</td><td>${t.priority}</td>
//       <td><button onclick="deleteTask(${t.id})">Delete</button></td></tr>`;
//     });
//     html += '</table>';
//     document.getElementById('task-container').innerHTML = html;
//   });
// }

// function addTask() {
//   const title = document.getElementById('title').value;
//   const deadline = document.getElementById('deadline').value;
//   const priority = document.getElementById('priority').value;

//   fetch('task_crud.php', {
//     method: 'POST',
//     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//     body: `action=create&title=${encodeURIComponent(title)}&deadline=${encodeURIComponent(deadline)}&priority=${encodeURIComponent(priority)}`
//   }).then(response => {
//     if (response.ok) {
//       alert('Task successfully added!');
//       location.reload(); 
//     } else {
//       alert('There was an error adding the task.');
//     }
//   });
// }

// function deleteTask(id) {
//   fetch('task_crud.php', {
//     method: 'POST',
//     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//     body: `action=delete&id=${id}`
//   }).then(response => {
//     if (response.ok) {
//       alert('Task successfully deleted!');
//       location.reload(); 
//     } else {
//       alert('There was an error deleting the task.');
//     }
//   });
// }

// document.addEventListener('DOMContentLoaded', fetchTasks);







// Fetch tasks for the logged-in user
function fetchTasks() {
  fetch('task_crud.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'action=read'
  })
  .then(res => res.json())
  .then(data => {
    let html = '';
    data.forEach(task => {
      html += `<tr>
        <td>${task.title}</td>
        <td>${task.deadline}</td>
        <td>${task.priority}</td>
        <td>${task.status}</td>
        <td>
          <button onclick="editTask(${task.id})" class="btn btn-warning btn-sm">Edit</button>
          <button onclick="deleteTask(${task.id})" class="btn btn-danger btn-sm">Delete</button>
        </td>
      </tr>`;
    });
    document.getElementById('task-list').innerHTML = html;
  });
}

// Add a new task
function addTask() {
  const title = document.getElementById('title').value;
  const deadline = document.getElementById('deadline').value;
  const priority = document.getElementById('priority').value;

  fetch('task_crud.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=create&title=${encodeURIComponent(title)}&deadline=${encodeURIComponent(deadline)}&priority=${encodeURIComponent(priority)}`
  })
  .then(() => {
    alert('Task added successfully!');
    fetchTasks(); // Refresh the task list
  });
}

// Delete a task
function deleteTask(id) {
  fetch('task_crud.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=delete&id=${id}`
  })
  .then(() => {
    alert('Task deleted successfully!');
    fetchTasks(); // Refresh the task list
  });
}

// Edit a task (you can add functionality here for editing a task if needed)
function editTask(id) {
  // Populate the form with task data for editing (optional)
  alert("Edit task functionality is not implemented yet.");
}

// Fetch tasks when the page is ready
document.addEventListener('DOMContentLoaded', fetchTasks);
