document.addEventListener("DOMContentLoaded", function () {
	var formAluno = document.getElementById("formAluno");
	if (formAluno) {
		formAluno.addEventListener("submit", function (event) {
			var nome = document.getElementById("nome").value.trim();
			var matricula = document.getElementById("matricula");
			var usuario = document.getElementById("usuario").value.trim();
			var email = document.getElementById("email").value.trim();
			var celular = document.getElementById("celular").value.trim();
			var gestor = document.getElementById("gestor");
			var senha = document.getElementById("senha");

			if (nome === "") {
				alert("Por favor, preencha o Nome Completo.");
				event.preventDefault();
				return;
			}
			if (matricula && !matricula.disabled) {
				var matriculaVal = matricula.value.trim();
				var regexMatricula = /^[0-9]{11}$/;
				if (!regexMatricula.test(matriculaVal)) {
					alert(
						"A matrícula do aluno deve conter exatamente 11 dígitos numéricos.",
					);
					matricula.focus();
					event.preventDefault();
					return;
				}
			}
			if (usuario === "") {
				alert("Por favor, preencha o Nome de Usuário.");
				event.preventDefault();
				return;
			}

			var regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!regexEmail.test(email)) {
				alert(
					"Por favor, informe um endereço de e-mail em formato válido.",
				);
				event.preventDefault();
				return;
			}

			if (celular !== "") {
				var celularLimpo = celular.replace(/\D/g, "");
				if (celularLimpo.length < 10 || celularLimpo.length > 11) {
					alert(
						"O número do celular deve conter 10 ou 11 dígitos numéricos (com DDD).",
					);
					event.preventDefault();
					return;
				}
			}

			if (gestor && gestor.checked) {
				if (
					senha &&
					senha.hasAttribute("required") &&
					senha.value.trim() === ""
				) {
					alert(
						"A senha de acesso é obrigatória para usuários do perfil Gestor.",
					);
					senha.focus();
					event.preventDefault();
					return;
				}
			}
		});
	}

	var formLivro = document.getElementById("formLivro");
	if (formLivro) {
		formLivro.addEventListener("submit", function (event) {
			var titulo = document.getElementById("titulo").value.trim();
			var autores = document.getElementById("autores").value.trim();
			var editora = document.getElementById("editora").value.trim();
			var edicao = parseInt(document.getElementById("edicao").value, 10);
			var anoPublicacao = parseInt(
				document.getElementById("ano_publicacao").value,
				10,
			);
			var quantidadeInput = document.getElementById("quantidade");

			var anoAtual = new Date().getFullYear();

			if (titulo === "" || autores === "" || editora === "") {
				alert(
					"Por favor, preencha todos os campos textuais obrigatórios.",
				);
				event.preventDefault();
				return;
			}

			if (isNaN(edicao) || edicao <= 0) {
				alert("O número de edição deve ser maior ou igual a 1.");
				event.preventDefault();
				return;
			}

			if (
				isNaN(anoPublicacao) ||
				anoPublicacao < 1500 ||
				anoPublicacao > anoAtual + 1
			) {
				alert(
					"Por favor, preencha um ano de publicação plausível (entre 1500 e " +
						(anoAtual + 1) +
						").",
				);
				event.preventDefault();
				return;
			}

			if (quantidadeInput) {
				var quantidade = parseInt(quantidadeInput.value, 10);
				if (isNaN(quantidade) || quantidade <= 0) {
					alert(
						"A quantidade de exemplares criada deve ser de no mínimo 1.",
					);
					event.preventDefault();
					return;
				}
			}
		});
	}

	var formLogin = document.getElementById("formLogin");
	if (formLogin) {
		formLogin.addEventListener("submit", function (event) {
			var usuario = document.getElementById("usuario").value.trim();
			var senha = document.getElementById("senha").value;

			if (usuario === "" || senha === "") {
				alert("Por favor, preencha o nome de usuário e a senha.");
				event.preventDefault();
				return;
			}
		});
	}

	var formDevolucao = document.getElementById("formDevolucao");
	if (formDevolucao) {
		formDevolucao.addEventListener("submit", function (event) {
			var selecionados = document.querySelectorAll(
				".check-devolucao:checked",
			);
			if (selecionados.length === 0) {
				alert(
					"Por favor, marque pelo menos um exemplar da tabela antes de registrar a devolução.",
				);
				event.preventDefault();
				return;
			}

			var confirmar = confirm(
				"Confirmar a devolução física de " +
					selecionados.length +
					" livro(s)?",
			);
			if (!confirmar) {
				event.preventDefault();
			}
		});
	}
});
