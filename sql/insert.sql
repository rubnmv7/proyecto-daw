-- ═══════════════════════════════════════════
-- DATOS DE PRUEBA - FANFIA
-- ═══════════════════════════════════════════
-- Contraseña para todos los usuarios de prueba: 1234
-- El admin tiene email admin@fanfia.com

INSERT INTO usuarios (ID_usuario, email, contraseña, nombre_usuario, tipo_usuario, foto_perfil, fecha_creacion)
VALUES
(1, 'admin@fanfia.com', '$2b$10$KeFTLVMSAZfNvR9t124rNOl7iNWT9reG4ZVm5r.NFAsSY2K06Htm6', 'AdminFanfia', 'Admin', NULL, '2026-01-15'),
(2, 'autor@fanfia.com', '$2b$10$KeFTLVMSAZfNvR9t124rNOl7iNWT9reG4ZVm5r.NFAsSY2K06Htm6', 'LunaEscarlata', 'Normal', NULL, '2026-02-10'),
(3, 'lector@fanfia.com', '$2b$10$KeFTLVMSAZfNvR9t124rNOl7iNWT9reG4ZVm5r.NFAsSY2K06Htm6', 'NocheEstelar', 'Normal', NULL, '2026-03-05');

INSERT INTO fanfics (ID_fanfic, ID_usuario, titulo, descripcion, estado, cantidad_capitulos, fecha_actualizacion)
VALUES
(1, 2, 'El legado del Fénix', 'En un mundo donde la magia se ha extinguido, una joven descubre que lleva en su sangre el último rescoldo del poder ancestral. Ahora deberá enfrentarse a un imperio que lleva siglos ocultando la verdad.', 'Terminado', 3, '2026-04-20'),
(2, 3, 'Sombras en Konoha', 'Naruto despierta en una línea temporal donde nunca existió el sellamiento del Kyubi. Sin la carga del demonio zorro, pero también sin su poder, deberá encontrar su propio camino para convertirse en Hokage.', 'En progreso', 2, '2026-05-10'),
(3, 2, 'Mar de estrellas', 'Un astronauta solitario queda varado en un planeta desconocido. Allí descubrirá que las estrellas no son lo que parecen y que el universo guarda secretos que la humanidad no está preparada para conocer.', 'Borrador', 1, '2026-05-01');

INSERT INTO capitulos (ID_capitulo, ID_fanfic, titulo, contenido, numero_capitulo, longitud)
VALUES
(1, 1, 'El despertar', 'Eira despertó sobresaltada. El sueño había sido el mismo de siempre: llamas danzando en la oscuridad, una voz que susurraba su nombre entre el humo. Se incorporó en la cama, sintiendo el frío de la mañana en su piel. Fuera, el sol apenas comenzaba a iluminar las calles empedradas de Valdheim. Desde pequeña había sentido que algo dentro de ella ardía en silencio, una chispa que no sabía explicar. Su abuela decía que los sueños eran mensajes, pero nunca llegó a revelarle su significado. Ahora, con diecisiete años, Eira estaba a punto de descubrir que la llama no era solo un sueño.\n\nEl día transcurría con normalidad en el mercado, hasta que un grupo de soldados del Imperio irrumpió entre los puestos. Buscaban a alguien. Buscaban a los que aún llevaban la marca de la magia en la sangre. Eira sintió el miedo recorrerle la espalda cuando uno de ellos se detuvo frente a ella, mirándola fijamente.\n\n—Tú —dijo el soldado—. Ven con nosotros.', 1, 987),
(2, 1, 'El refugio', 'Eira logró escapar gracias a la confusión del mercado. Corrió sin mirar atrás, escondiéndose entre callejones hasta llegar al viejo templo en las afueras. Allí, entre las ruinas cubiertas de hiedra, encontró un altar que brillaba débilmente. Al tocarlo, sintió un calor recorrerle el brazo, y una llama azul danzó en la palma de su mano. La magia había vuelto.\n\nUn anciano apareció entre las sombras. —Llevaba siglos esperando a alguien como tú —dijo, revelando que era el último guardián del conocimiento ancestral. Le explicó que el Imperio no solo había ocultado la magia, sino que la había absorbido para sí mismo, alimentando un poder oscuro que amenazaba con devorar el mundo.', 2, 654),
(3, 1, 'La confrontación', 'Armada con el conocimiento del guardián y el poder del fénix que llevaba dentro, Eira se enfrentó al emperador. La batalla final se libró en el palacio de cristal, donde las llamas azules chocaron contra la oscuridad acumulada durante siglos. Eira descubrió que el emperador no era un tirano cualquiera: era el primer fénix, corrompido por el poder. Con un último sacrificio, Eira liberó la magia atrapada, devolviéndola al mundo. El imperio cayó, pero ella perdió su llama en el proceso. Al despertar, ya no era especial. Solo una chica que había hecho lo correcto.', 3, 823);

INSERT INTO generos (ID_genero, nombre_genero)
VALUES
(1, 'Aventura'),
(2, 'Fantasía'),
(3, 'Romance'),
(4, 'Acción'),
(5, 'Misterio');

INSERT INTO tienen (ID_fanfic, ID_genero)
VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 1),
(2, 2),
(2, 4),
(3, 1),
(3, 5);

INSERT INTO valoraciones (ID_valoracion, ID_fanfic, fecha_valoracion, comentario, tipo_valoracion)
VALUES
(1, 1, '2026-04-25', 'Me encantó el desarrollo de Eira, muy bien escrito. La escena final es impresionante.', 'Positiva'),
(2, 1, '2026-04-28', 'El principio es un poco lento, pero merece la pena llegar al final.', 'Positiva'),
(3, 2, '2026-05-12', 'Original idea con Naruto, pero el segundo capítulo se hace corto. Necesito más.', 'Positiva'),
(4, 2, '2026-05-15', 'No me gustó cómo cambia la personalidad de Naruto, no encaja con el personaje original.', 'Negativa');
