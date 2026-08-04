<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
DROP FUNCTION IF EXISTS public.fn_insertar_usuario(character varying, character varying, character varying);

CREATE FUNCTION public.fn_insertar_usuario(
    p_nombre character varying,
    p_email character varying,
    p_password character varying,
    p_identificador character varying
) RETURNS TABLE(mensaje character varying, error integer)
LANGUAGE plpgsql
AS $$
BEGIN
    IF COALESCE(TRIM(p_nombre), '') = '' THEN
        RETURN QUERY SELECT 'El nombre no puede estar vacío'::VARCHAR, 1;
        RETURN;
    END IF;

    IF COALESCE(TRIM(p_email), '') = '' THEN
        RETURN QUERY SELECT 'El correo electrónico no puede estar vacío'::VARCHAR, 1;
        RETURN;
    END IF;

    IF COALESCE(TRIM(p_password), '') = '' THEN
        RETURN QUERY SELECT 'La contraseña no puede estar vacía'::VARCHAR, 1;
        RETURN;
    END IF;

    IF COALESCE(TRIM(p_identificador), '') = '' THEN
        RETURN QUERY SELECT 'El identificador no puede estar vacío'::VARCHAR, 1;
        RETURN;
    END IF;

    IF EXISTS (
        SELECT 1
        FROM public.users
        WHERE LOWER(email) = LOWER(p_email)
    ) THEN
        RETURN QUERY SELECT 'El correo electrónico ya se encuentra registrado'::VARCHAR, 1;
        RETURN;
    END IF;

    INSERT INTO public.users (
        name,
        email,
        email_verified_at,
        password,
        remember_token,
        created_at,
        updated_at,
        user_estado,
        identificador
    ) VALUES (
        p_nombre,
        p_email,
        NULL,
        p_password,
        NULL,
        NOW(),
        NOW(),
        1,
        TRIM(p_identificador)
    );

    RETURN QUERY SELECT 'Usuario registrado correctamente'::VARCHAR, 0;
EXCEPTION
    WHEN OTHERS THEN
        RETURN QUERY SELECT ('Ocurrió un error: ' || SQLERRM)::VARCHAR, 1;
END;
$$;
SQL);
    }

    public function down(): void
    {
        DB::unprepared(<<<'SQL'
DROP FUNCTION IF EXISTS public.fn_insertar_usuario(character varying, character varying, character varying, character varying);

CREATE FUNCTION public.fn_insertar_usuario(
    p_nombre character varying,
    p_email character varying,
    p_password character varying
) RETURNS TABLE(mensaje character varying, error integer)
LANGUAGE plpgsql
AS $$
BEGIN
    IF COALESCE(TRIM(p_nombre), '') = '' THEN
        RETURN QUERY SELECT 'El nombre no puede estar vacío'::VARCHAR, 1;
        RETURN;
    END IF;

    IF COALESCE(TRIM(p_email), '') = '' THEN
        RETURN QUERY SELECT 'El correo electrónico no puede estar vacío'::VARCHAR, 1;
        RETURN;
    END IF;

    IF COALESCE(TRIM(p_password), '') = '' THEN
        RETURN QUERY SELECT 'La contraseña no puede estar vacía'::VARCHAR, 1;
        RETURN;
    END IF;

    IF EXISTS (
        SELECT 1
        FROM public.users
        WHERE LOWER(email) = LOWER(p_email)
    ) THEN
        RETURN QUERY SELECT 'El correo electrónico ya se encuentra registrado'::VARCHAR, 1;
        RETURN;
    END IF;

    INSERT INTO public.users (
        name,
        email,
        email_verified_at,
        password,
        remember_token,
        created_at,
        updated_at,
        user_estado
    ) VALUES (
        p_nombre,
        p_email,
        NULL,
        p_password,
        NULL,
        NOW(),
        NOW(),
        1
    );

    RETURN QUERY SELECT 'Usuario registrado correctamente'::VARCHAR, 0;
EXCEPTION
    WHEN OTHERS THEN
        RETURN QUERY SELECT ('Ocurrió un error: ' || SQLERRM)::VARCHAR, 1;
END;
$$;
SQL);
    }
};
