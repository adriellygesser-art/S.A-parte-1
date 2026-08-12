from flask import Flask, render_template, request, redirect, url_for,session,flash
app = Flask(__name__)
app.secret_key = 'segredo_super_importante'  # necessário para usar session
import mysql.connector


# ========= CONEXÃO COM BANCO ==========
def conectar():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",  # coloque sua senha do MySQL
        database="vetket",
        port= 3306
    )


dados_pessoais = []

@app.route('/')
def login():
    # Se já estiver logado, vai direto pra index
    if session.get('logado'):
        return redirect(url_for('index'))
    return render_template('login.html')

@app.route('/login', methods=['POST'])
def login_post():
    usuario = request.form.get('usuario')
    senha = request.form.get('senha')

    conexao = conectar()
    cursor = conexao.cursor(dictionary=True)
    cursor.execute("SELECT * FROM responsavel WHERE nome=%s AND senha=%s", (usuario, senha))
    user = cursor.fetchone()
    cursor.close()
    conexao.close()

    if user:
        session['logado'] = True
        session['nome'] = user['nome']
        session['senha'] = user['senha']
        
       
        return redirect(url_for('index'))
    else:
        flash('Usuário ou senha incorretos.', 'erro')
        return redirect(url_for('login'))



    
@app.route('/logout')
def logout():
    session.clear()
    flash('Você saiu do sistema.', 'info')
    return redirect(url_for('login'))

@app.route('/cadastro', methods=['GET', 'POST'])
def cadastro():
    if request.method == 'POST':

        usuario = request.form.get('usuario')
        senha = request.form.get('senha')

        conexao = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="vetket",
            port= 3306
        )
        cursor = conexao.cursor()

        sql = "INSERT INTO responsavel (nome, senha) VALUES (%s, %s)"
        valores = (usuario, senha)
        cursor.execute(sql, valores)

        conexao.commit()
        cursor.close()
        conexao.close()

        flash("Usuário cadastrado com sucesso!", "sucesso")

        # VOLTA PARA LOGIN JÁ PREENCHIDO
        return redirect(url_for('login', usuario=usuario, senha=senha))

    return render_template('cadastro.html')




@app.route('/index')
def index():
    if not session.get('logado'):
        return redirect(url_for('login'))
    return render_template('index.html')


@app.route('/agendamento', methods=['GET', 'POST'])
def agendamento():
    if not session.get('logado'):
        return redirect(url_for('login'))

    if request.method == 'POST':
        nome = request.form.get('nome')
        email = request.form.get('email')
        telefone = request.form.get('telefone')
        especie = request.form.get('especie')
        agendamento = request.form.get('agendamento')
        horario = request.form.get('horario')
        if nome and email and telefone and especie and agendamento and horario:
            dados_pessoais.append({
                'nome': nome,
                'email': email,
                'telefone': telefone,
                'especie': especie,
                'agendamento': agendamento,
                'horario': horario
            })
            return redirect(url_for('listar'))
    return render_template('agendamento.html')


@app.route('/listar')
def listar():
    if not session.get('logado'):
        return redirect(url_for('login'))
    return render_template('listar.html', dados=dados_pessoais)

@app.route('/sobre')
def sobre():
    # Se já estiver logado, vai direto pra index
  
    return render_template('sobre.html')


if __name__ == '__main__':
    app.run(debug=True)
