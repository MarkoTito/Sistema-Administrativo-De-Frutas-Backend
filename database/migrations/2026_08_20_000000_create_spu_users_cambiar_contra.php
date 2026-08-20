<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE OR REPLACE FUNCTION public.spu_users_cambiar_contra(
    p_id_user bigint,
    p_password character varying
) RETURNS TABLE(mensa character varying, error integer, numid integer)
LANGUAGE plpgsql
AS $$
BEGIN
    IF p_id_user IS NULL OR p_id_user <= 0 THEN
        RETURN QUERY SELECT 'El usuario no es válido'::VARCHAR, 1, 0;
        RETURN;
    END IF;

    IF COALESCE(TRIM(p_password), '') = '' THEN
        RETURN QUERY SELECT 'La contraseña no puede estar vacía'::VARCHAR, 1, 0;
        RETURN;
    END IF;

    UPDATE public.users
    SET password = p_password,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_id_user;

    IF NOT FOUND THEN
        RETURN QUERY SELECT 'El usuario no existe'::VARCHAR, 1, 0;
        RETURN;
    END IF;

    RETURN QUERY SELECT 'Contraseña actualizada correctamente'::VARCHAR, 0, p_id_user::INTEGER;
EXCEPTION
    WHEN OTHERS THEN
        RETURN QUERY SELECT ('Ocurrió un error: ' || SQLERRM)::VARCHAR, 1, 0;
END;
$$;
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS public.spu_users_cambiar_contra(bigint, character varying)');
    }
};
