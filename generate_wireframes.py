import json
import uuid

# Configuration for v5 Dark Theme
COLORS = {
    "bg": "#0f111a",
    "surface": "#1f2937", 
    "border": "#374151",
    "text_primary": "#f3f4f6",
    "text_secondary": "#9ca3af",
    "accent": "#3b82f6", 
    "danger": "#ef4444",
    "success": "#10b981",
    "table_header_bg": "#111827"
}

SCREEN_WIDTH = 1200
SCREEN_HEIGHT = 1000 # Increased height for details
SIDEBAR_WIDTH = 250
HEADER_HEIGHT = 80
PADDING = 20

current_x = 0
current_y = 0
elements = []

def create_element(type, x, y, width, height, **kwargs):
    return {
        "id": str(uuid.uuid4()),
        "type": type,
        "x": x,
        "y": y,
        "width": width,
        "height": height,
        "angle": 0,
        "strokeColor": kwargs.get("strokeColor", COLORS["border"]),
        "backgroundColor": kwargs.get("backgroundColor", "transparent"),
        "fillStyle": kwargs.get("fillStyle", "solid"),
        "strokeWidth": 1,
        "strokeStyle": "solid",
        "roughness": 0,
        "opacity": 100,
        "groupIds": [],
        "roundness": kwargs.get("roundness", { "type": 3 }),
        "seed": 123456,
        "version": 1,
        "versionNonce": 0,
        "isDeleted": False,
        "boundElements": [],
        "updated": 1,
        "link": None,
        "locked": False,
        "text": kwargs.get("text", ""),
        "fontSize": kwargs.get("fontSize", 16),
        "fontFamily": 1,
        "textAlign": kwargs.get("textAlign", "left"),
        "verticalAlign": "top",
        "baseline": 15,
    }

def draw_text(x, y, text, color=COLORS["text_primary"], size=16, align="left", bold=False):
    return create_element("text", x, y, len(text)*10, size*1.5, text=text, strokeColor=color, fontSize=size, textAlign=align, fontFamily=3)

def draw_rect(x, y, w, h, bg, stroke=COLORS["border"]):
    return create_element("rectangle", x, y, w, h, backgroundColor=bg, strokeColor=stroke, fillStyle="solid")

def draw_icon(x, y, type="edit"):
    # Simple placeholder icons
    color = COLORS["accent"]
    if type == "delete": color = COLORS["danger"]
    if type == "add": color = COLORS["success"]
    return draw_rect(x, y, 24, 24, color)

def draw_button(x, y, label, variant="primary"):
    bg = COLORS["accent"]
    text_color = "#ffffff"
    
    if variant == "secondary":
        bg = COLORS["surface"]
        text_color = COLORS["text_primary"]
    elif variant == "danger":
        bg = COLORS["danger"]
        
    rect = draw_rect(x, y, 120, 40, bg)
    text = draw_text(x + 60, y + 10, label, text_color, 14, "center")
    return [rect, text]

def draw_layout(x, y, title):
    group = []
    # Main Background
    group.append(draw_rect(x, y, SCREEN_WIDTH, SCREEN_HEIGHT, COLORS["bg"]))
    
    # Sidebar
    group.append(draw_rect(x, y, SIDEBAR_WIDTH, SCREEN_HEIGHT, COLORS["surface"]))
    group.append(draw_text(x + 20, y + 30, "ProjectMgr", COLORS["accent"], 24, bold=True))
    
    menu_items = ["Dashboard", "Projetos", "Tarefas", "Users", "Equipas", "Formação", "Formadores", "Cronogramas"]
    for i, item in enumerate(menu_items):
        color = COLORS["accent"] if item in title else COLORS["text_secondary"]
        group.append(draw_text(x + 30, y + 100 + (i * 50), item, color, 16))

    # Header
    group.append(draw_rect(x + SIDEBAR_WIDTH, y, SCREEN_WIDTH - SIDEBAR_WIDTH, HEADER_HEIGHT, COLORS["surface"], "transparent"))
    group.append(draw_text(x + SIDEBAR_WIDTH + 30, y + 25, title, COLORS["text_primary"], 20, bold=True))
    
    # User Profile (Top Right)
    group.append(draw_text(x + SCREEN_WIDTH - 150, y + 25, "Auth User", COLORS["text_secondary"], 16))
    
    return group

def draw_table(x, y, title, headers, rows_count=3, action_buttons=None):
    group = []
    
    # Table Title & Action
    if title:
        group.append(draw_text(x, y, title, COLORS["text_primary"], 18, bold=True))
        if action_buttons:
             group.extend(draw_button(x + 400, y - 5, action_buttons, "secondary"))
        y += 40

    col_width = (SCREEN_WIDTH - SIDEBAR_WIDTH - 100) / len(headers)
    
    # Header Row
    group.append(draw_rect(x, y, SCREEN_WIDTH - SIDEBAR_WIDTH - 60, 40, COLORS["table_header_bg"]))
    for i, h in enumerate(headers):
        group.append(draw_text(x + 20 + (i * col_width), y + 10, h, COLORS["text_secondary"], 14))
        
    # Data Rows
    for r in range(rows_count):
        row_y = y + 40 + (r * 50)
        group.append(draw_rect(x, row_y, SCREEN_WIDTH - SIDEBAR_WIDTH - 60, 50, COLORS["bg"] if r % 2 == 0 else COLORS["surface"], "transparent"))
        for i in range(len(headers)):
            # Actions Column
            if headers[i].lower() == "actions" or headers[i].lower() == "tools":
                group.append(draw_icon(x + 20 + (i * col_width), row_y + 12, "view"))
                group.append(draw_icon(x + 50 + (i * col_width), row_y + 12, "edit"))
                group.append(draw_icon(x + 80 + (i * col_width), row_y + 12, "delete"))
            else:
                group.append(draw_rect(x + 20 + (i * col_width), row_y + 15, col_width - 40, 10, COLORS["surface"], COLORS["border"]))
            
    return group, row_y + 60 # Return next Y position

def draw_key_value_grid(x, y, data):
    group = []
    # Draw a 3-column grid
    col_width = 300
    row_height = 80
    
    keys = list(data.keys())
    for i, key in enumerate(keys):
        col = i % 3
        row = i // 3
        
        px = x + (col * col_width)
        py = y + (row * row_height)
        
        group.append(draw_text(px, py, key, COLORS["text_secondary"], 12))
        group.append(draw_text(px, py + 25, data[key], COLORS["text_primary"], 16, bold=True))
        group.append(draw_rect(px, py + 55, 250, 2, COLORS["border"]))
        
    return group, y + ((len(keys)//3 + 1) * row_height) + 20

def draw_form_fields(x, y, fields):
    group = []
    current_y = y
    
    for field in fields:
        label, type = field
        group.append(draw_text(x, current_y, label, COLORS["text_secondary"], 14))
        
        if type == "textarea":
            group.append(draw_rect(x, current_y + 30, 800, 100, COLORS["bg"], COLORS["border"]))
            current_y += 150
        elif type == "checkbox_group":
             group.append(draw_rect(x, current_y + 30, 800, 80, COLORS["bg"], COLORS["border"]))
             group.append(draw_text(x + 10, current_y + 40, "[ ] Option 1   [ ] Option 2", COLORS["text_primary"], 14))
             current_y += 130
        else:
            group.append(draw_rect(x, current_y + 30, 800, 40, COLORS["bg"], COLORS["border"]))
            current_y += 90
            
    return group, current_y

def add_screen(screen_func):
    global current_x, current_y, elements
    elements.extend(screen_func(current_x, current_y))
    current_x += SCREEN_WIDTH + 150
    # Wrap
    if current_x > (SCREEN_WIDTH + 150) * 4:
        current_x = 0
        current_y += SCREEN_HEIGHT + 150

# --- SCREENS ---

def screen_dashboard(x, y):
    els = draw_layout(x, y, "Dashboard")
    # KPI Cards
    labels = ["Active Projects", "Pending Tasks", "Team Members", "Upcoming Trainings"]
    for i, lbl in enumerate(labels):
        els.append(draw_rect(x + SIDEBAR_WIDTH + 30 + (i * 220), y + 100, 200, 100, COLORS["surface"]))
        els.append(draw_text(x + SIDEBAR_WIDTH + 50 + (i * 220), y + 120, lbl, COLORS["text_secondary"], 12))
        els.append(draw_text(x + SIDEBAR_WIDTH + 50 + (i * 220), y + 150, "12", COLORS["text_primary"], 24, bold=True))

    tbl, _ = draw_table(x + SIDEBAR_WIDTH + 30, y + 250, "Recent Activity", ["Code", "Designation", "Status", "Date"], 5)
    els.extend(tbl)
    return els

# --- PROJECTS ---

def screen_project_view(x, y):
    els = draw_layout(x, y, "Ver Projeto (View)")
    # Action Header
    els.extend(draw_button(x + SCREEN_WIDTH - 150, y + 90, "Edit", "primary"))
    
    # Details Grid
    grid, next_y = draw_key_value_grid(x + SIDEBAR_WIDTH + 30, y + 100, {
        "Codigo do Projeto": "PRJ-2024-001",
        "Designacao": "Website Redesign",
        "Estado": "Em Curso",
        "Descricao": "Complete overhaul of the legacy system..."
    })
    els.extend(grid)
    
    # Teams Table
    tbl1, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Equipas do Projeto", ["Designacao da Equipa", "Funcao", "Actions"], 2, "Add Team")
    els.extend(tbl1)
    
    # Tasks Table
    tbl2, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Tarefas do Projeto", ["Designacao", "Estado", "Descricao"], 3)
    els.extend(tbl2)
    
    return els

def screen_project_create(x, y):
    els = draw_layout(x, y, "Criar Projeto")
    
    fields = [
        ("Designacao do Projeto", "text"),
        ("Acronimo", "text"),
        ("Estado", "select"),
        ("Equipas (Checkboxes)", "checkbox_group"),
        ("Descricao", "textarea")
    ]
    form, next_y = draw_form_fields(x + SIDEBAR_WIDTH + 30, y + 100, fields)
    els.extend(form)
    els.extend(draw_button(x + SIDEBAR_WIDTH + 30, next_y + 20, "Registrar"))
    
    return els

# --- TEAMS ---

def screen_teams_view(x, y):
    els = draw_layout(x, y, "Ver Equipa")
    els.extend(draw_button(x + SCREEN_WIDTH - 150, y + 90, "Edit"))
    
    grid, next_y = draw_key_value_grid(x + SIDEBAR_WIDTH + 30, y + 100, {
        "Designacao": "Backend Devs",
        "Funcao": "API Development"
    })
    els.extend(grid)
    
    # Users Table
    tbl1, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Utilizadores da Equipa", ["Nome", "Email", "Actions"], 3, "Add User")
    els.extend(tbl1)
    
    # Projects Table
    tbl2, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Projetos da Equipa", ["Designacao", "Estado", "Descricao", "Actions"], 2, "Add Project")
    els.extend(tbl2)
    
    return els

# --- TRAININGS ---

def screen_trainings_view(x, y):
    els = draw_layout(x, y, "Ver Formacao")
    els.extend(draw_button(x + SCREEN_WIDTH - 150, y + 90, "Edit"))
    
    grid, next_y = draw_key_value_grid(x + SIDEBAR_WIDTH + 30, y + 100, {
        "Codigo": "TR-001",
        "Designacao": "Laravel Security",
        "Estado": "Scheduled"
    })
    els.extend(grid)
    
    # Users Table
    tbl1, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Participantes (Utilizadores)", ["Nome", "Email"], 4, "Add Users")
    els.extend(tbl1)
    
    # Formers Table
    tbl2, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Formadores", ["Nome", "Email"], 1)
    els.extend(tbl2)
    
    return els

# --- USERS ---

def screen_users_view(x, y):
    els = draw_layout(x, y, "Ver Utilizador")
    els.extend(draw_button(x + SCREEN_WIDTH - 150, y + 90, "Edit"))
    
    grid, next_y = draw_key_value_grid(x + SIDEBAR_WIDTH + 30, y + 100, {
        "Nome": "John Doe",
        "Email": "john@example.com"
    })
    els.extend(grid)
    
    # Roles Table
    tbl1, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Funcoes (Roles)", ["Nome da Funcao", "Actions"], 2, "Add Role")
    els.extend(tbl1)
    
    # Projects Table
    tbl2, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Projetos Associados", ["Codigo", "Designacao"], 2)
    els.extend(tbl2)

    # Tasks Table
    tbl3, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Tarefas Associadas", ["Codigo", "Designacao"], 3)
    els.extend(tbl3)
    
    return els

# --- FORMERS ---

def screen_formers_view(x, y):
    els = draw_layout(x, y, "Ver Formador")
    els.extend(draw_button(x + SCREEN_WIDTH - 150, y + 90, "Edit"))
    
    grid, next_y = draw_key_value_grid(x + SIDEBAR_WIDTH + 30, y + 100, {
        "Nome": "Jane Smith",
        "Email": "jane.former@example.com"
    })
    els.extend(grid)
    
    # Trainings Table
    tbl1, next_y = draw_table(x + SIDEBAR_WIDTH + 30, next_y, "Formacoes Ministradas", ["Codigo", "Designacao"], 3)
    els.extend(tbl1)
    
    return els

# --- GENERATION LOOP ---

screens = [
    screen_dashboard,
    screen_project_view,
    screen_project_create,
    screen_teams_view,
    screen_trainings_view,
    screen_users_view,
    screen_formers_view,
]

for screen in screens:
    add_screen(screen)

# Wrap in Excalidraw JSON format
output = {
    "type": "excalidraw",
    "version": 2,
    "source": "https://excalidraw.com",
    "elements": elements,
    "appState": { "viewBackgroundColor": "#000000", "gridSize": 20 }
}

print(json.dumps(output, indent=2))