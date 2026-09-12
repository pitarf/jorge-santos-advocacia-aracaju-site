<?php
/**
 * Sincronizador Automático de Layouts e Páginas Elementor via Tema
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Hook via URL direta: ?sync_elementor=jorge_aracaju_2026
add_action( 'init', function() {
	if ( isset( $_GET['sync_elementor'] ) && $_GET['sync_elementor'] === 'jorge_aracaju_2026' ) {
		$log = jorge_executar_sincronizacao_elementor();
		$log_html = '<ul>';
		foreach ($log as $l) {
			$log_html .= "<li style='text-align:left;margin-bottom:6px;font-size:14px;'>$l</li>";
		}
		$log_html .= '</ul>';

		wp_die( '<div style="font-family:sans-serif;padding:30px;background:#071220;color:#fff;text-align:center;border-radius:8px;max-width:700px;margin:50px auto;border:2px solid #C5A880;"><h2 style="color:#C9A45C;margin-top:0;">Sincronização Concluída com Sucesso!</h2><div style="background:#0b1b2d;padding:15px;border-radius:6px;max-height:300px;overflow-y:auto;margin:20px 0;border:1px solid #1a365d;">' . $log_html . '</div><a href="/" style="display:inline-block;padding:12px 24px;background:#C9A45C;color:#071220;text-decoration:none;font-weight:bold;border-radius:4px;">Ver Página Inicial</a></div>' );
	}
} );

// 2. Função de Sincronização
function jorge_executar_sincronizacao_elementor() {
	$json_file = get_template_directory() . '/elementor_sync_data.json';
	$log = [];

	if ( ! file_exists( $json_file ) ) {
		$log[] = "ERRO: Arquivo elementor_sync_data.json não encontrado no tema.";
		return $log;
	}

	$pages = json_decode( file_get_contents( $json_file ), true );
	if ( empty( $pages ) ) {
		$log[] = "ERRO: elementor_sync_data.json está vazio ou inválido.";
		return $log;
	}

	foreach ( $pages as $orig_id => $data ) {
		$target_post = null;

		// 1. Tentar achar pela Home se for a página inicial
		if ( $data['post_name'] === 'home' || $data['post_name'] === 'inicio' || $orig_id == 37 ) {
			$front_page_id = get_option( 'page_on_front' );
			if ( $front_page_id ) {
				$target_post = get_post( $front_page_id );
			}
		}

		// 2. Tentar por post_name / slug
		if ( ! $target_post ) {
			$found = get_posts( [
				'name'           => $data['post_name'],
				'post_type'      => [ 'page', 'elementor_library' ],
				'post_status'    => 'any',
				'posts_per_page' => 1
			] );
			if ( ! empty( $found ) ) {
				$target_post = $found[0];
			}
		}

		// 3. Tentar pelo mesmo ID original
		if ( ! $target_post ) {
			$by_id = get_post( $orig_id );
			if ( $by_id && in_array( $by_id->post_type, [ 'page', 'elementor_library' ] ) ) {
				$target_post = $by_id;
			}
		}

		if ( $target_post ) {
			$post_id = $target_post->ID;
			update_post_meta( $post_id, '_elementor_data', wp_slash( json_encode( $data['elementor_data'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) ) );
			update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );

			if ( ! empty( $data['page_settings'] ) ) {
				update_post_meta( $post_id, '_elementor_page_settings', $data['page_settings'] );
			}
			if ( ! empty( $data['rank_math'] ) ) {
				update_post_meta( $post_id, 'rank_math_title', $data['rank_math']['title'] );
				update_post_meta( $post_id, 'rank_math_description', $data['rank_math']['desc'] );
				update_post_meta( $post_id, 'rank_math_focus_keyword', $data['rank_math']['focus'] );
			}
			$log[] = "✔ Atualizado: <strong>{$data['post_title']}</strong> (ID no banco: {$post_id})";
		} else {
			$log[] = "⚠ Página não encontrada: <strong>{$data['post_title']}</strong> (slug: {$data['post_name']})";
		}
	}

	// Limpar cache de CSS do Elementor
	if ( class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
		$log[] = "✔ Cache de CSS do Elementor regenerado com sucesso!";
	}

	return $log;
}
