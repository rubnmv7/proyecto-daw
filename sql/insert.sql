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
(3, 1, 'Choque Fraternal de Acero', 'Un entrenamiento amistoso entre los hermanos Elric se convierte rápidamente en una batalla de orgullo y alquimia a gran escala.', 'Terminado', 1, '2026-05-25'),
(4, 1, 'Aroma a hogar', 'Una noche tranquila en :re se convierte en un tierno momento de conexión entre Kaneki y Touka.', 'Terminado', 1, '2026-05-25'),
(5, 1, 'La Isla del Gran Rebote', 'Luffy encuentra una isla donde todo rebota y la comida es aún más difícil de atrapar, ¡pero más divertida!', 'Terminado', 1, '2026-05-25'),
(6, 1, 'Un Recado con Sabor a Acero', 'Chihiro tiene un simple encargo, pero algunos magos de poca monta no están de acuerdo con sus planes de una tarde tranquila.', 'Terminado', 1, '2026-05-25'),
(7, 1, 'El Nuevo Sabor del Ramen', 'Naruto Uzumaki empieza a notar que hay sabores y sentimientos más complejos que el ramen... y que Hinata Hyuga tiene mucho que ver con eso.', 'Terminado', 1, '2026-05-25'),
(8, 1, 'Un Buen Día Raro', 'Denji solo quiere una vida normal, pero cuando la normalidad empieza a sentirse como una broma pesada, hasta un buen día puede volverse extrañamente pegajoso.', 'Terminado', 1, '2026-05-25');

INSERT INTO capitulos (ID_capitulo, ID_fanfic, titulo, contenido, numero_capitulo, longitud)
VALUES
(3, 3, 'Capítulo 1', 'El sol de la tarde apenas se asomaba sobre los edificios de Central, tiñéndolos de un naranja apagado. Yo estaba apoyado contra una pared de ladrillos en un solar abandonado, bostezando. Al me miraba con su armadura imponente, su voz resonando en el casco hueco.

"Hermano, ¿estás seguro de que esto es una buena idea? Acabamos de salir de una misión y podrías estar cansado."

Cansado, ¿yo? ¡Por favor! "¡No digas tonterías, Al! ¡Siempre hay tiempo para un buen entrenamiento! Además, últimamente te has vuelto bastante bueno, es hora de que te ponga en tu sitio. Necesito afilar mis habilidades, y ¿quién mejor que mi propio hermano de metal para ello?" Le guiñé un ojo, aunque sabía que no podía verlo.

Al soltó un suspiro, el sonido un poco metálico. "Si insistes, hermano. Pero no hagamos demasiado alboroto. Y no uses la transmutación humana."

"¡Obviamente que no usaré la transmutación humana, idiota!" Me impulsé del muro, estirando mis brazos. "¡Solo quiero ver qué tan rápido te has vuelto! ¡Así que, vamos, Al! ¡Dame todo lo que tienes!"

Una pequeña sonrisa se formó en la superficie de su casco, o al menos así lo imaginé. "De acuerdo, hermano. Pero no te quejes si termino siendo un poco... rudo."

"¡Como si pudieras!" Me reí, y el desafío estaba lanzado.

Sin esperar más, corrí hacia él. Mi automail resonó contra el suelo mientras me acercaba, transmutando el suelo bajo sus pies en un par de pinchos de piedra afilados. Al reaccionó instantáneamente, golpeando el suelo con su pesado puño. Una pared de tierra se elevó entre nosotros, deteniendo mis proyectiles.

"¡Nada mal, Al! ¡Pero necesitas ser más rápido!" Corrí hacia la pared, golpeándola con mi mano enguantada. La piedra se transformó en una rampa improvisada, y la usé para saltar por encima.

Una vez en el aire, mi automail brilló. Transmuté mi brazo derecho en una hoja dentada y me lancé hacia él. Al levantó su propio brazo, y su antebrazo se ensanchó y endureció, volviéndose más grueso y resistente que el acero normal. El choque fue un estruendo metálico que hizo eco en el solar. Chispas volaron por todas partes mientras nuestras "armas" se encontraban.

"¡Eres más pesado de lo que recuerdo, gigante de metal!" jadeé, aplicando más fuerza.

"Has perdido agilidad, hermano," respondió Al con calma, empujándome hacia atrás.

Era verdad, estaba perdiendo terreno. Di una voltereta hacia atrás para alejarme, y mientras aterrizaba, golpeé el suelo con mi pie izquierdo. El pavimento se levantó en una serie de puños de piedra que se dirigían directamente hacia Al. No esperaba que fueran a derribarlo, pero sí a distraerlo.

Al saltó hacia atrás con una sorprendente gracia para su tamaño, esquivando los puños. Luego, con una mano, transmutó el suelo a su alrededor, creando un muro ondulante que me rodeó. Los muros se cerraban, intentando acorralarme.

"¡Maldición, Al! ¡Estás siendo demasiado! ¡No tienes que intentar aplastarme!" grité, aunque una sonrisa se dibujaba en mis labios. Este era el tipo de entrenamiento que me gustaba.

Rápidamente golpeé uno de los muros con mi mano. En lugar de destruirlo, lo transformé en una catapulta. La piedra se dobló y me lanzó por encima de las paredes que Al había creado. En el aire, giré, y usé mi automail para impulsar una patada fuerte.

Al previó mi movimiento. En lugar de defenderse directamente, golpeó el suelo con ambos puños. La tierra tembló, y dos pilares gruesos de roca surgieron a cada lado de mí, justo cuando estaba a punto de aterrizar. Mi patada se encontró con uno de ellos en lugar de con su armadura. El impacto me hizo rebotar, y caí de pie, pero ligeramente desequilibrado.

"¡Tramposo!" acusé, resoplando.

"¡Solo uso lo que tengo a mano, hermano!" replicó Al, y juro que noté un deje de diversión en su voz.

Al corrió hacia mí esta vez, su paso resonando como un trueno. No parecía un gigante torpe en este momento; era una mole imparable. Golpeó el suelo, y una onda de energía sísmica viajó hacia mí. Tuve que saltar rápidamente para evitarla, y mientras estaba en el aire, Al me lanzó una serie de fragmentos de roca transmutados, como balas.

Golpeé los fragmentos con mi automail, desviándolos, pero era una distracción. Mientras estaba ocupado, Al ya estaba encima de mí. Me empujó con su enorme mano de metal, y me envió rodando por el suelo. Logré recuperar el equilibrio justo antes de chocar contra la pared de ladrillos.

"¡Uf! ¡Eso estuvo cerca!" Me sacudí el polvo. "¡Parece que el gigante ha estado practicando!"

Esta vez, no esperé. Golpeé el suelo con ambas manos. La tierra se abrió a mi alrededor en una especie de falla zigzagueante, de la que emergieron tentáculos de piedra afilados. Los dirigí hacia Al, que se mantenía firme. Al soltó un grito de guerra, su voz resonando desde el casco, y golpeó el suelo una vez más. Una cúpula protectora de roca sólida se formó a su alrededor, deteniendo mis ataques.

"¡No te escondas detrás de la defensa, Al! ¡Muéstrame lo que tienes de verdad!" grité, sabiendo que mi paciencia se estaba agotando.

Mientras la cúpula aún estaba formándose, corrí hacia ella. Golpeé con mi automail, y en lugar de romperla, la transmuté. La cúpula comenzó a transformarse, no en algo afilado o destructivo, sino en un puño gigante de roca. No un puño cerrado, sino uno que se abría hacia Al, intentando atraparlo dentro.

Al, atrapado por la sorpresa de la velocidad de mi transmutación, tuvo que actuar rápido. Vi un flash de energía alquímica, y la cúpula que lo rodeaba se rompió en docenas de fragmentos. Pero no eran simples rocas; eran afilados como cuchillas, y volaron hacia mí como un enjambre furioso.

"¡Oh, vamos! ¡Eso es trampa, Al! ¡No puedes devolverme mis propios ataques!" Grité, usando mis brazos para protegerme, mientras los fragmentos raspaban mi piel y hacían sonar mi automail.

La lluvia de fragmentos me hizo retroceder. En ese momento, Al aprovechó. Cargó con la velocidad de un tren, directamente hacia mí. No usó alquimia, solo su peso puro y su fuerza.

No tenía tiempo para transmutar algo grande. Con un último grito de frustración y pura adrenalina, golpeé el suelo con mi mano enguantada, transmutando el trozo de tierra más cercano a mí en una tabla de lanzamiento. Salté sobre ella justo cuando Al estaba a punto de chocar. La tabla me lanzó por encima de su cabeza.

Al siguió su impulso, chocando contra la pared de ladrillos que antes me protegía. Un enorme agujero se abrió en la pared, y Al se detuvo justo a tiempo, su cuerpo de metal temblando ligeramente por el impacto.

Aterricé detrás de él, jadeando. Mi brazo automail palpitaba, y podía sentir algunos rasguños en mi cara. "¡Uf! ¡Casi me conviertes en un panqueque, Al!"

Al se giró lentamente, su armadura crujiendo. "Y tú casi me encierras en una jaula de piedra, hermano." Extendió su mano, y la energía alquímica se desvaneció. "Parece que estamos en un empate, hermano. Ambos nos hemos superado un poco."

Miré mi brazo automail, luego a la pared destrozada. Una risa floja se escapó de mis labios. "Supéralo, Al. Yo gané. Te hice chocar contra esa pared como un idiota."

Al suspiró, su cabeza inclinándose ligeramente. "Claro, hermano. Lo que digas. ¿Ahora podemos ir a comer? Tengo mucha hambre después de ese... entrenamiento."

Una sonrisa más grande se dibujó en mi cara. "¡Ahora sí que hablas! Pero esta vez, tú invitas. Después de cómo te luciste, es lo menos que puedes hacer."

Mientras salíamos del solar, dejando atrás el rastro de nuestra amistosa batalla, no pude evitar sentir un escalofrío. Al se había vuelto realmente bueno. La próxima vez, tendría que ir con todo.', 1, 5113),
(4, 4, 'Capítulo 1', 'El aroma a café recién molido siempre me ha traído una extraña paz, incluso en los días más agitados. Esta noche, sin embargo, el silencio de :re después de cerrar, solo roto por el suave zumbido de la nevera y el repiqueteo ocasional de la lluvia contra el cristal, lo hacía aún más profundo y envolvente. Estaba repasando los libros, la luz de la pequeña lámpara de la barra iluminando mis apuntes, pero mi mente divagaba. Era en estos momentos de calma cuando más apreciaba la vida que habíamos construido.

La puerta tintineó suavemente, anunciando la llegada de Touka. Se deslizó dentro, sus movimientos fluidos y seguros, con ese aire de determinación cansada que siempre me ha parecido tan fascinante. Llevaba su chaqueta de trabajo, aún con un par de manchas de café que no había tenido tiempo de limpiar. Sus ojos, de un azul profundo que a veces recordaba el cielo al atardecer, me miraron con una mezcla de cansancio y un afecto que yo reconocía como mío.

"¿Terminaste ya con los números, cerebrito?", preguntó, apoyándose en la barra justo frente a mí, su voz un murmullo que se mezclaba con el sonido de la lluvia.

Le ofrecí una pequeña sonrisa. "Casi. ¿Ichika ya está dormida?"

Ella suspiró, un sonido que era mitad alivio, mitad agotamiento. "Por fin. Ha sido un día movido. Estaba pidiendo otra historia, pero al final se rindió. Cayó dormida abrazada a su conejito."

Terminé de cerrar el libro de contabilidad con un suave golpe. "Parece que nos espera una noche tranquila."

Touka asintió, estirándose un poco y haciendo crujir sus hombros. "Necesito un café. ¿Te apetece uno?"

"Siempre", respondí, mientras me ponía de pie para ir por las tazas. Preparar café para Touka era un ritual que nunca me cansaba. Molí los granos, sintiendo su fragancia especiada llenar el aire, un aroma a hogar para mí. Vertí el agua caliente, observando cómo la infusión oscura goteaba lentamente, hipnotizado por el proceso.

Ella se sentó en uno de los taburetes altos, observándome con una calma que antes habría creído imposible para nosotros.

Le entregué su taza humeante. Ella la tomó con ambas manos, dejando que el calor le llegara a los dedos. "Gracias, Kaneki."

Nos quedamos en silencio un momento, bebiendo el café. El sabor era rico y reconfortante, amargo con un toque dulce al final. La lluvia arreciaba un poco, pero dentro del café, todo era calidez y sosiego.

"Sabes...", empecé, mirándola por encima del borde de mi taza. "Nunca pensé que la normalidad se sentiría tan bien."

Touka me miró, una chispa divertida en sus ojos. "¿Normalidad? ¿Con nosotros? Lo dices como si nuestra vida fuera aburrida."

Me reí suavemente. "No, no aburrida. Es diferente. Es estar aquí, contigo, después de un día, sabiendo que Ichika está a salvo durmiendo en casa. Es un tipo de felicidad que nunca creí posible."

Ella apoyó su taza en la barra, luego extendió una mano y rozó la mía suavemente. "Yo tampoco. Y no lo cambiaría por nada." Su mirada se suavizó, volviéndose tierna. "Me alegro de que seas tú, Kaneki."

Mi corazón se apretó de una manera dulce. A veces, las palabras eran superfluas. Un toque, una mirada, y el simple hecho de compartir el silencio eran suficientes. Entrelacé mis dedos con los suyos, sintiendo la calidez de su piel.

"Yo también me alegro de que seas tú, Touka", susurré, mis ojos fijos en los suyos.

Y en esa quietud, en el suave aroma a café, la lluvia constante y el tenue brillo de las luces del café, supe que habíamos encontrado nuestro propio rincón de cielo. Un cielo no exento de cicatrices, pero lleno de una luz que era solo nuestra.', 1, 3130),
(5, 5, 'Capítulo 1', '¡Uhm, uhm, uhm! ¡Qué hambre tengo! Llevábamos un día entero sin pisar tierra, y mi estómago ya estaba haciendo ruidos raros. ¡Pero entonces, Nami gritó!

"¡Tierra a la vista! ¡Y parece que hay árboles!"

"¡Árboles significan fruta! ¡Y fruta significa comida!" Me estiré un poco, sintiendo el viento en mi cara. El Going Merry se acercaba a una isla que no parecía muy grande, pero era de un verde súper intenso.

"¡Rápido, Sanji! ¡Prepara algo para cuando volvamos!" grité, ya listo para saltar.

Sanji asomó la cabeza por la cocina, encendiendo un cigarrillo. "¡Cállate, cabeza hueca! ¡Primero hay que ver qué hay!" Pero su ojo ya brillaba. "Aunque huelo algo... ¡dulce! ¡Quizás un nuevo ingrediente!"

"¡Zoro, no te duermas!" dijo Nami, señalando con su dedo. "¡Vamos a explorar! ¡Luffy, no te vayas solo!"

Pero yo ya había saltado al bote. "¡Shishishishi! ¡Soy el primero!"

Cuando llegamos a la orilla, el suelo se sentía... ¡raro! Era blando, como si caminara sobre un colchón gigante. ¡Y olía a algo dulce y fresco!

"¡Wow! ¡Esto es como mi cuerpo! ¡Goma-goma!" exclamé, dando un gran salto. ¡Fui impulsado hacia arriba! Nami gritó, y Sanji casi se cae.

"¡Luffy, ten cuidado!" dijo Nami. "¡El suelo es elástico! ¡Es como un trampolín gigante!"

¡Un trampolín gigante! ¡Esto era la isla más divertida de todas! Empecé a rebotar por todas partes, riendo a carcajadas.

"¡Mira, Sanji! ¡Aquí hay árboles!" grité, señalando unos árboles enormes y altos con unas frutas de color violeta intenso que parecían nubes.

Sanji se acercó, sus ojos con forma de corazón. "¡Oh, la Fruta-Nube! ¡Se dice que son las frutas más raras y deliciosas del Grand Line! ¡Un postre exquisito! ¡Pero son casi imposibles de atrapar!"

Me acerqué a un árbol y estiré mi brazo. "¡Goma-Goma... Brazo Elástico!" Intenté agarrar una, pero justo cuando mi mano la tocó, ¡la fruta saltó! ¡Rebotó en una hoja del árbol y salió disparada hacia arriba!

"¡Oh, no!" Nami se quejó. "¡Es por el suelo elástico! ¡Los árboles también son elásticos, y las frutas rebotan con cualquier movimiento! ¡Cazarlas será una pesadilla!"

"¡Qué pasada!" exclamé. "¡Esto es como un juego!"

De repente, un pequeño pájaro azul con un pico largo y puntiagudo salió de entre las hojas. Era rápido, y con un graznido agudo, ¡agarró una de las frutas-nube y se fue volando!

"¡Eh, ese pájaro nos robó una fruta!" dije, inflando mis mejillas.

"¡Es un Pico Saltador!" dijo Nami. "¡Son muy listos y comen estas frutas! ¡Será difícil competir con ellos!"

"¡No hay problema!" dije, sonriendo. "¡Yo soy Luffy! ¡Y soy un hombre de goma! ¡Y atraparé todas esas frutas-nube!"

Empecé a rebotar con más fuerza. Saltaba de árbol en árbol, usando mis brazos como lianas elásticas. El Pico Saltador chirriaba y se lanzaba para atrapar las frutas que yo soltaba, pero yo era más rápido, o al menos, ¡más pegajoso!

"¡Goma-Goma... Red de Manos!" extendí mis brazos y piernas, creando una especie de red elástica gigante. Cuando el pájaro intentó pasar, ¡rebotó en mí!

Saltaba y me estiraba, creando rebotes con mi cuerpo para que las frutas cayeran en mis manos, o rebotaran hacia Sanji, que las atrapaba con destreza.

"¡Sanji, mira! ¡Tenemos un montón!" grité, mostrando un puñado de frutas-nube. Eran suaves, de un color violeta brillante, y olían increíblemente bien.

Sanji ya estaba babeando. "¡Excelente, Luffy! ¡Con esto podré hacer mi famoso batido de Fruta-Nube con toque de caramelo! ¡Y tal vez unas tartas!"

Antes de irnos, dejé unas cuantas frutas-nube en el suelo para el Pico Saltador. El pájaro me miró, ladeó la cabeza, y luego picoteó una con gusto. ¡Parecía contento!

De vuelta en el barco, Sanji se puso a trabajar de inmediato. "¡Aquí tenéis, mis hermosas damas y mis brutos compañeros!" gritó Sanji, sirviendo unos vasos altos con un batido violeta espumoso y unas pequeñas tartas.

"¡Qué rico!" exclamó Chopper, con la nariz llena de nata.

Probé el batido. ¡Era dulce y ligero, como si bebiera una nube! ¡Y la tarta era suave y se deshacía en la boca!

"¡Shishishishi! ¡Esto es increíble, Sanji!" grité, con la boca llena. "¡La mejor fruta que hemos encontrado en mucho tiempo!"

Mientras navegábamos hacia nuestra siguiente aventura, me recosté en la cabeza del Going Merry, sintiendo el suave balanceo del barco. La Isla del Gran Rebote había sido una pasada. Me pregunté qué tipo de isla encontraríamos a continuación. ¡Pero seguro que sería una aventura!', 1, 4578),
(6, 6, 'Capítulo 1', 'El sol de la tarde ya se estaba despidiendo, tiñendo los edificios abandonados de un naranja melancólico que a nadie le importaba, excepto quizás a mí. No era por la belleza, sino por la luz tenue; la hora perfecta para que los rateros y los aspirantes a magos con dos hechizos y medio cerebro salieran de sus escondites. Hoy, mi misión era simple: recoger un paquete de datos cifrados de un buzón muerto en los viejos almacenes del distrito este.

"Otro día, otra interrupción", murmuré para mí, ajustando el peso de mi katana, Enten, en la espalda.

Avanzaba por un pasillo entre dos almacenes de chapa oxidada, el aire cargado con el olor a humedad y metal viejo. Mis sentidos, afinados por años de peleas y la constante vigilia, comenzaron a cosquillear. Tres presencias, no particularmente poderosas, pero definitivamente hostiles. Escondidos. Uno detrás de unos barriles, otro en el tejado de un camión volcado, y el tercero intentaba camuflarse con una lona mugrienta que lo hacía parecer más un fantasma mal cubierto que un depredador.

"En serio", pensé con una mueca interna. "Una lona. Al menos pongan un poco de esfuerzo."

Continué mi paso como si no hubiera notado nada. El que estaba detrás de los barriles se movió primero, un torpe paso en falso. Un mago de aspecto desaliñado, empuñando una especie de bastón corto del que ya se desprendían chispas anaranjadas.

"¡Quieto ahí, chico bonito!", gritó el del camión, un tipo grande con una cicatriz cruzando la cara. "¿No sabes que esta es nuestra zona?"

El de la lona intentó flanquearme por la izquierda, pero tropezó ligeramente con su propio pie. Me detuve.

"No, no lo sabía", respondí con calma, mi mano ya en la empuñadura de Enten. "Pero gracias por la información."

El mago del bastón lanzó su hechizo, una bola de energía naranja que venía lenta y ruidosa hacia mí. No tuve que ni moverme mucho; un simple paso lateral bastó para esquivarla.

Mientras tanto, el grandullón del camión saltó, blandiendo un machete oxidado con un grito de guerra que sonó más a un bostezo. Y el fantasma de la lona, finalmente liberándose de su sábana, reveló a un joven nervioso con un par de dagas.

El machete del grandullón venía con intención, pero su velocidad era patética. Enten salió de su vaina en un parpadeo de acero, interceptando el golpe con un tintineo limpio. No busqué herirlo; solo desvié la trayectoria de su arma, enviando el machete volando hacia el cielo para que se clavara en el suelo a unos metros.

"¡Mi machete!", gimió el grandullón.

Mientras él se distraía, el mago del bastón ya estaba cargando otro hechizo. Corrí hacia él, mi velocidad lo tomó por sorpresa. Antes de que pudiera terminar de formar su ataque, ya estaba detrás de él, y la funda de Enten le golpeó suavemente la nuca, lo suficiente para aturdirlo.

Solo quedaba el acróbata nervioso. Me giré hacia él, con Enten aún desenvainada. El chico tragó saliva, sus ojos buscando una salida. Blandió sus dagas con poca convicción.

"Escucha", le dije, mi voz tranquila pero firme. "No tengo tiempo para esto. Mi recado es urgente."

El chico dudó, sus dagas temblaban. Entonces, en un intento desesperado, lanzó ambas dagas a la vez. Una pasó silbando junto a mi oreja; la otra, la desvié con un movimiento indolente de Enten.

El joven, al ver el fracaso de su último recurso, simplemente dejó caer sus hombros. "Vale. Me rindo. Lo siento. Creí que serías fácil."

"Pocos lo son", respondí, volviendo a envainar Enten.

El grandullón, que había logrado recuperar su machete, lo guardó con resignación. El mago del bastón aún se estaba frotando la nuca.

"Si van a seguir en esto", les aconsejé, antes de darme la vuelta, "al menos intenten coordinarse. Y usen algo más que una lona. Es embarazoso."

Los dejé atrás, susurrando y refunfuñando. Recuperé el paquete de datos, sin más incidentes. Otro recado cumplido, una interrupción menor solventada. A veces, la vida de un portador de katana mágica era extrañamente mundana.', 1, 3928),
(7, 7, 'Capítulo 1', 'El aroma a miso y a cerdo asado siempre me había parecido la perfección, la única verdad en este mundo complicado. Acababa de salir de Ichiraku, la barriga llena y el corazón contento. Iba caminando por las calles de Konoha, silbando una melodía que probablemente solo existía en mi cabeza, cuando la vi.

Hinata Hyuga. Estaba ayudando a una anciana a levantar unas cestas de verduras que se le habían caído. Sus movimientos eran suaves, precisos, como siempre. Su pelo oscuro brillaba bajo el sol de la tarde y, aunque no la oía, sabía que estaba hablando con su voz baja y amable.

Una punzada extraña me recorrió el pecho. No era hambre, porque acababa de engullir tres tazones. No era agotamiento, porque me sentía fresco como una lechuga. Era... diferente. Como cuando te comes un dango picante sin esperarlo. Me rasqué la cabeza, confundido.

Al día siguiente, después de una sesión de entrenamiento infernal con Kakashi-sensei, decidí ir a mi lugar secreto para pensar: el banco junto al río, con vista a las caras de los Hokage. Pero alguien ya estaba allí. Era Hinata, sentada tranquilamente, con un pequeño cuaderno en sus manos.

"¡Oi, Hinata!" grité, más fuerte de lo que pretendía.

Ella dio un pequeño salto, y el cuaderno se le resbaló de las manos, cayendo abierto al suelo. Se sonrojó hasta las orejas al verme.

"N-Naruto-kun..." susurró, agachándose rápidamente para recogerlo.

Me acerqué, curioso. "¿Qué haces por aquí? ¿Mirando flores, dattebayo?"

Ella asintió, recogiendo el cuaderno. "Estaba... dibujando algunas flores de loto. Son para un paciente en el hospital. Le gustan mucho."

Siempre tan considerada. Me senté a su lado, dejando caer mi bolsa de kunais con un golpe sordo. Miré las flores que había dibujado. Eran delicadas y hermosas, mucho mejores de lo que yo podría hacer.

"Son muy bonitas, Hinata. Eres buena dibujando."

Ella se sonrojó aún más, bajando la mirada. "G-gracias, Naruto-kun."

Hubo un silencio cómodo. Se sentía... raro. Diferente a cuando estaba con Sakura o con Shikamaru. Era un silencio suave, cálido. Y entonces volvió. Esa punzada, ese algo extraño en mi pecho. Pero esta vez, no era picante. Era más bien... dulce.

"Oye, ¿estás bien, Naruto-kun?" su voz me sacó de mis pensamientos.

"¡Eh? ¡Sí, claro! ¡Estoy más que bien! ¡Nunca he estado mejor! ¡Dattebayo!" dije, quizás con demasiada efusividad.

Unos días después, pasando por un campo de entrenamiento, la vi practicando sus jutsus del Puño Suave. Sus movimientos eran fluidos, gráciles, pero con una potencia silenciosa. Me quedé observándola un rato, escondido entre los árboles.

"¡Hinata! ¡Buen entrenamiento! ¡Te estás haciendo más fuerte, dattebayo!"

Ella se giró de golpe. "¡N-Naruto-kun! No te había visto..."

"¡Perdona! Estaba de paso y te vi entrenar. ¡Eres increíble!"

Ella desvió la mirada. "No es para tanto. Solo intento... mejorar."

Me acerqué a ella. "Ya eres genial. Siempre has sido genial." Las palabras salieron sin pensar, pero eran verdad.

"Oye, ¿vas a casa? Te acompaño."

Ella me miró sorprendida, pero asintió tímidamente. Empezamos a caminar. El sol ya empezaba a ponerse, tiñendo el cielo de tonos anaranjados y rosados.

"Naruto-kun... has crecido mucho. Siempre me inspiraste. Tu determinación, tu forma de nunca rendirte. Por eso... por eso yo también quiero ser fuerte."

Sus palabras me llegaron directamente al corazón. Miré su perfil, la suave curva de su nariz, el brillo en sus ojos cuando me miraba. Me di cuenta de que esa sensación... no era ni el chile, ni el anko. Era Hinata. Era ella la que me hacía sentir así.

Llegamos a la entrada del complejo Hyuga. Me detuve. Ella también.

"Hinata..." empecé. "Tú... eres genial, ¿sabes?"

Ella me miró, y por primera vez, su sonrisa no fue solo tímida. Fue radiante.

"Oye, Hinata. ¿Te gustaría... ir a Ichiraku alguna vez? Solo tú y yo. Sin misiones, sin entrenamientos. Solo... ramen."

Sus ojos se abrieron ligeramente. Luego, un rubor más profundo cubrió su rostro. "S-sí... Me gustaría mucho, Naruto-kun."

Una sonrisa estúpida, de oreja a oreja, se instaló en mi cara. "¡Genial! ¡Pues... te avisaré!"

Me di la vuelta y empecé a caminar, sintiendo el aire ligero y mi paso flotante. La punzada dulce seguía allí, y esta vez, sabía exactamente lo que era. Era la emoción de un nuevo descubrimiento, el sabor de algo que no era ramen, pero que prometía ser igual de bueno.', 1, 4456),
(8, 8, 'Capítulo 1', 'Me desperté de un golpe. O eso pensé. La verdad es que no estoy seguro de si me desperté o si simplemente pasé de un sueño a otro, solo que este era el de la "realidad". Tenía el pijama enredado, como siempre, y el sol se colaba por la ventana, pegándome directo en la cara. Un día nuevo. Perfecto.

Me estiré, bostecé, y el primer pensamiento en mi cabeza fue: "Tengo hambre". Como siempre. Me levanté, tropezando un poco con Nayuta que estaba durmiendo en el suelo, hecha una bolita. La aparté con el pie suavemente. Ella gruñó y se dio la vuelta.

Fui a la cocina, abrí la nevera. Quedaba un poco de ese yogur de fresa barato que tanto me gusta, y unos panecillos. Empecé a prepararlo. Pero cuando metí la primera cucharada de yogur en la boca, algo se sintió raro. No estaba mal, pero tampoco estaba bien. Era como si el sabor estuviera ahí, pero no lo sintiera del todo. Como si alguien le hubiera quitado la chispa.

"Bah, debe ser mi cabeza", pensé.

Después de encargarme de Nayuta, decidí salir a dar una vuelta. Cogí mis llaves, mi cartera, y salí. La calle estaba llena de gente, como siempre. Coches, ruidos, voces. Traté de encontrar una dirección, pero no sabía a dónde ir. Simplemente caminé.

Y mientras caminaba, la cosa se puso más rara. Las caras de la gente. Eran normales, sí, pero había algo. Sus sonrisas eran demasiado anchas a veces, o sus ojos parpadeaban demasiado lento. Y a veces me parecía que las mismas tres o cuatro caras se repetían. Un tipo con bigote comprando el periódico aquí, y luego, a dos calles, el mismo tipo con bigote comprando en otra tienda.

"Debo estar más cansado de lo que pensaba", me dije.

Pasé por una pastelería. Olía a bollos recién hechos, a azúcar. Mi estómago volvió a rugir, esta vez con ganas. Entré. Pedí una de esas tartas de crema con fresas, las que me gustan a mí. Pagué y salí a la calle, emocionado. Esto sí que me alegraría el día.

Me senté en un banco, saqué la tarta con cuidado. La primera cucharada. Cremosa, dulce, con el toque ácido de la fresa. Cerré los ojos, saboreándola. Ah, esto es vida. Abrí los ojos, y miré la tarta. Estaba ahí, preciosa, pero el sabor se desvanecía en mi boca. Se volvía a ese dulce vacío de antes. Era como si mi cerebro registrara el sabor, pero mi cuerpo no lo disfrutara. Dejé la tarta.

Volví a casa, cabizbajo. Nayuta estaba sentada en el sofá, viendo dibujos.

"¿Todo bien, Denji?", me preguntó.

"Sí, sí. Solo... no sé. Estoy un poco apagado", le dije.

Me senté a su lado, intentando concentrarme en la tele. Era un programa de comedia. La gente en la tele se reía a carcajadas. Yo intenté reír, pero mi boca no quería. Luego, en un corte, vi mi reflejo en la pantalla apagada. Mi cara. Pero la mirada estaba vacía. Y detrás de mí, por un instante, vi una silueta. Dos cuernos. Un motor. Pochita. Pero no era el Pochita que yo conocía. Este era estático. Como una imagen congelada. Me di la vuelta. No había nada.

Me levanté y fui al baño. Me miré al espejo. Sonreí. La sonrisa se extendió en mi cara. Demasiado. Se hizo demasiado grande, enseñando todos los dientes. Y no eran mis dientes. Eran afilados. Como los de un demonio. Me sobresalté, retrocediendo. La imagen se distorsionó por un segundo, y volví a ver mi sonrisa normal.

Acerqué mi mano al espejo. Mis dedos. Luego, parpadeé, y por un microsegundo, las uñas se alargaron, se hicieron negras, y las falanges se volvieron como de metal. Una sierra. La sierra de Pochita.

Retiré la mano como si me hubiera quemado. Respiré hondo.

"Ya está", me dije. "Probablemente solo necesito dormir. O comer algo que de verdad tenga sabor."

Volví a la cocina. Abrí la nevera de nuevo. No había nada especial. Cogí un poco de pan y queso. Empecé a masticar. Nada. Solo la textura. Sin sabor.

Tiré el pan. La desesperación empezó a asomarse, una sensación fría en mi pecho. Me senté en el suelo de la cocina, apoyando la espalda en la nevera.

"¿Por qué nada sabe a nada?", susurré. "Quiero comer algo rico. Quiero ver algo divertido. Quiero... sentir algo."

Me quedé ahí un rato, sentado en el suelo, escuchando el zumbido de la nevera. Era un día normal. Era un buen día. Pero se sentía tan jodidamente pegajoso. Como si todo estuviera cubierto de una capa invisible de plástico que impedía que nada me llegara de verdad.

Me puse de pie. "Bah", dije en voz alta. "Seguro que solo necesito una buena película de acción."

Fui a la sala, me senté al lado de Nayuta. Cogí el mando, busqué una película ruidosa. Empezó. Explosiones, disparos, gritos. Todo sonaba. Todo se veía. Pero era como si lo viera a través de un cristal. Sin poder tocarlo. Sin que me tocara a mí.

Me quedé mirando la pantalla, esperando que algo se sintiera real. Pero lo único que sentía era ese extraño vacío, ese zumbido constante, y la certeza de que algo, en algún lugar, no estaba bien. Y por primera vez en mucho tiempo, me pregunté si ese "algo" no estaba dentro de mí.', 1, 5260);

INSERT INTO generos (ID_genero, nombre_genero)
VALUES
(1, 'Aventura'),
(2, 'Fantasía'),
(3, 'Romance'),
(4, 'Acción'),
(5, 'Misterio'),
(6, 'Drama'),
(7, 'Terror'),
(8, 'Psicológico');

INSERT INTO tienen (ID_fanfic, ID_genero)
VALUES
(3, 1), (3, 4),
(4, 3),
(5, 1),
(6, 4),
(7, 3),
(8, 7), (8, 8);
