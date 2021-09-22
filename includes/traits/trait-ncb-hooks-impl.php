<?php
/**
 * Naran Code Base: Hooks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! trait_exists( 'NCB_Hooks_Impl' ) ) {
	trait NCB_Hooks_Impl {
		/**
		 * Add action(s)
		 *
		 * @param string                              $tag
		 * @param callable[]|callable|string[]|string $function_to_add
		 * @param int|null                            $priority
		 * @param int                                 $accepted_args
		 *
		 * @return self
		 */
		protected function add_action(
			string $tag,
			$function_to_add,
			?int $priority = null,
			int $accepted_args = 1
		): self {
			$priority = $this->get_priority( $priority );

			if ( is_array( $function_to_add ) && ! is_callable( $function_to_add ) ) {
				array_map( function ( $item ) use ( $tag, $priority, $accepted_args ) {
					$function = $this->parse_callback( $item );
					add_action( $tag, $function, $priority, $accepted_args );
				}, $function_to_add );
			} else {
				$function = $this->parse_callback( $function_to_add );
				add_action( $tag, $function, $priority, $accepted_args );
			}

			return $this;
		}

		/**
		 * Add filter(s)
		 *
		 * @param string                              $tag
		 * @param callable[]|callable|string[]|string $function_to_add
		 * @param int|null                            $priority
		 * @param int                                 $accepted_args
		 *
		 * @return self
		 */
		protected function add_filter(
			string $tag,
			$function_to_add,
			?int $priority = null,
			int $accepted_args = 1
		): self {
			$priority = $this->get_priority( $priority );

			if ( is_array( $function_to_add ) && ! is_callable( $function_to_add ) ) {
				array_map( function ( $item ) use ( $tag, $priority, $accepted_args ) {
					$function = $this->parse_callback( $item );
					add_filter( $tag, $function, $priority, $accepted_args );
				}, $function_to_add );
			} else {
				$function = $this->parse_callback( $function_to_add );
				add_filter( $tag, $function, $priority, $accepted_args );
			}

			return $this;
		}

		/**
		 * Remove action(s)
		 *
		 * @param string                              $tag
		 * @param callable[]|callable|string[]|string $function_to_remove
		 * @param int|null                            $priority
		 *
		 * @return $this
		 */
		protected function remove_action(
			string $tag,
			$function_to_remove,
			?int $priority = null
		): self {
			$priority = $this->get_priority( $priority );

			if ( is_array( $function_to_remove ) ) {
				array_map( function ( $item ) use ( $tag, $priority ) {
					$function = $this->parse_callback( $item );
					remove_action( $tag, $function, $priority );
				}, $function_to_remove );
			} else {
				$function = $this->parse_callback( $function_to_remove );
				remove_action( $tag, $function, $priority );
			}

			return $this;
		}

		/**
		 * Remove filter(s)
		 *
		 * @param string                              $tag
		 * @param callable[]|callable|string[]|string $function_to_remove
		 * @param int|null                            $priority
		 *
		 * @return $this
		 */
		protected function remove_filter(
			string $tag,
			$function_to_remove,
			?int $priority = null
		): self {
			$priority = $this->get_priority( $priority );

			if ( is_array( $function_to_remove ) ) {
				array_map( function ( $item ) use ( $tag, $priority ) {
					$function = $this->parse_callback( $item );
					remove_filter( $tag, $function, $priority );
				}, $function_to_remove );
			} else {
				$function = $this->parse_callback( $function_to_remove );
				remove_filter( $tag, $function, $priority );
			}

			return $this;
		}

		/**
		 * Parse callback function for actions and filters.
		 *
		 * @param $item
		 *
		 * @return callable|null
		 */
		private function parse_callback( $item ): ?callable {
			if ( is_string( $item ) && method_exists( $this, $item ) ) {
				return [ $this, $item ];
			} elseif ( is_callable( $item ) ) {
				return $item;
			}

			return null;
		}

		/**
		 * Get the priority
		 *
		 * @param ?int $priority
		 *
		 * @return int
		 */
		private function get_priority( ?int $priority ): int {
			return is_null( $priority ) ? $this->get_container()->get_priority() : $priority;
		}
	}
}
