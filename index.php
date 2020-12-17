<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Outliner</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">

    <link rel="stylesheet" href="assets/css/app.css?v=1.0">

</head>

<body>

    <div class="list-manager">
        <div class="left-bar">
            <section class="upper-part">
                <div class="actions">
                    <div class="circle-2"></div>
                </div>
            </section>
            <section class="left-content">
                <h1>My Lists</h1>
                <ul class="action-list">
                    <li class="item">
                        <a href="#">
                            Inbox
                        </a> 
                    </li>
                    <li class="item">
                        <a href="#">
                            Inbox
                        </a>
                    </li>
                    <li class="item">
                        <a href="#">
                            Inbox
                        </a>
                    </li>
                </ul>
                <ul class="category-list">
                    <li class="item">
                        <a href="#" id="settings">
                            Settings
                        </a>
                    </li>
                </ul>
            </section>
        </div>
        <div class="page-content">
            <div class="header">Today Tasks</div>
            <div class="content-categories">
                <div class="label-wrapper">
                    <input class="nav-item" name="nav" type="radio" id="opt-1">
                    <label class="category" for="opt-1">All</label>
                </div>
                <div class="label-wrapper">
                    <input class="nav-item" name="nav" type="radio" id="opt-2" checked>
                    <label class="category" for="opt-2">Important</label>
                </div>
                <div class="label-wrapper">
                    <input class="nav-item" name="nav" type="radio" id="opt-3">
                    <label class="category" for="opt-3">Notes</label>
                </div>
                <div class="label-wrapper">
                    <input class="nav-item" name="nav" type="radio" id="opt-4">
                    <label class="category" for="opt-4">Links</label>
                </div>
            </div>
            <div class="tasks-wrapper">
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-1" checked>
                    <label for="item-1">
                        <span class="label-text">Dashboard Design Implementation</span>
                    </label>
                    <span class="tag approved">Approved</span>
                </div>
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-2" checked>
                    <label for="item-2">
                        <span class="label-text">Create a userflow</span>
                    </label>
                    <span class="tag progress">In Progress</span>
                </div>
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-3">
                    <label for="item-3">
                        <span class="label-text">Application Implementation</span>
                    </label>
                    <span class="tag review">In Review</span>
                </div>
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-4">
                    <label for="item-4">
                        <span class="label-text">Create a Dashboard Design</span>
                    </label>
                    <span class="tag progress">In Progress</span>
                </div>
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-5">
                    <label for="item-5">
                        <span class="label-text">Create a Web Application Design</span>
                    </label>
                    <span class="tag approved">Approved</span>
                </div>
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-6">
                    <label for="item-6">
                        <span class="label-text">Interactive Design</span>
                    </label>
                    <span class="tag review">In Review</span>
                </div>
                <div class="header upcoming">Upcoming Tasks</div>
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-7">
                    <label for="item-7">
                        <span class="label-text">Dashboard Design Implementation</span>
                    </label>
                    <span class="tag waiting">Waiting</span>
                </div>
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-8">
                    <label for="item-8">
                        <span class="label-text">Create a userflow</span>
                    </label>
                    <span class="tag waiting">Waiting</span>
                </div>
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-9">
                    <label for="item-9">
                        <span class="label-text">Application Implementation</span>
                    </label>
                    <span class="tag waiting">Waiting</span>
                </div>
                <div class="task">
                    <input class="task-item" name="task" type="checkbox" id="item-10">
                    <label for="item-10">
                        <span class="label-text">Create a Dashboard Design</span>
                    </label>
                    <span class="tag waiting">Waiting</span>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/app.js"></script>
</body>

</html>
