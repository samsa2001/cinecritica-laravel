DELETE t1 FROM serie_actor_copy t1
INNER JOIN serie_actor_copy t2 
WHERE 
	 t1.id < t2.id and
    t1.serie_id = t2.serie_id AND
	 t1.persona_id = t2.persona_id AND
	 t1.orden = t2.orden;
