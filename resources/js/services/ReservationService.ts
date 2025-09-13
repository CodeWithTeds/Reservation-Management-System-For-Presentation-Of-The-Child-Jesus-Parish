import axios from 'axios';
import { Reservation } from '@/types';

/**
 * Service for handling reservation-related API calls
 */
export default {
  /**
   * Get all reservations for the current user
   * @returns Promise with reservation data
   */
  getReservations: async (): Promise<{
    reservations: Reservation[];
    stats: {
      total: number;
      pending: number;
      approved: number;
      cancelled: number;
    };
  }> => {
    const response = await axios.get('/api/reservations');
    return response.data;
  },

  /**
   * Get a specific reservation by ID
   * @param id Reservation ID
   * @returns Promise with reservation data
   */
  getReservation: async (id: number): Promise<Reservation> => {
    const response = await axios.get(`/api/reservations/${id}`);
    return response.data.reservation;
  },

  /**
   * Cancel a reservation
   * @param id Reservation ID
   * @returns Promise with success message
   */
  cancelReservation: async (id: number): Promise<{ success: boolean; message: string }> => {
    const response = await axios.post(`/api/reservations/${id}/cancel`);
    return response.data;
  },
};